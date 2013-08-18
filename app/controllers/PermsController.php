<?php
use aitiba\Perm\PermRepository as Perm;
class PermsController extends BaseController {
	/**
     * The Perm instance.
     *
     * @var \aitiba\Perm\Perm
     */
    private $perm;

    /**
     * Create a new User.
     *
     * @param  \aitiba\Perm\Perm  $userauth
     * @return void
     */
    public function __construct(Perm $perm)
    {
      $this->perm = $perm;
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$perms = $this->perm->findAll();
        return View::make('perms.index')->with('perms', $perms);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('perms.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$data = Input::all();
        
        $v = $this->perm->validation($data);
        if ( is_object($v) ) {
            return Redirect::route('perms.create')->withErrors($v)->withInput();
        }
        
        if ( $this->perm->store($data) )
        {
            return Redirect::route('perms.index')->with("flash_message", Lang::get('Permsuccesfully created!'));
        }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$perm = $this->perm->findOrFail($id);

        return View::make('perms.show')->with('perm', $perm);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$perm = $this->perm->find($id);
        if (!$perm) {
            return Redirect::route('perms.index');
        }
        return View::make('perms.edit')->with('perm', $perm);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$data = Input::all();
        $data['id'] = $id;
        $v = $this->perm->validation($data);
        if ( is_object($v) ) {
            return Redirect::route('perms.edit', $id)->withErrors($v)->withInput();
        }
        
        if ( $this->perm->update($data) )
        {
            return Redirect::route('perms.index')->with("flash_message", Lang::get('Perms succesfully edited!'));
        }
        return false;

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if($this->perm->destroy($id))
        {
            return Redirect::route('perms.index')->with("flash_message", Lang::get('Perms succesfully deleted!'));
        } else {
            return Redirect::route('perms.index')->with("flash_message", Lang::get('Perms problems to delete!'));
        }
	}

}