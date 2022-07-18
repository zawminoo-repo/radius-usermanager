<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Nas;

class NasController extends BaseController
{
    public function __construct()
	{
		$this->nas_model = model(Nas::class);
	}
	
	public function index()
    {
		$data['nases'] = $this->nas_model->findAll();
		return view('nas/list', $data);
    }
	
	public function create()
	{
		return view('nas/add');
	}
	
	public function store()
	{
		$rules = [ 'nasname'  => 'required'];
		
		if($this->request->getMethod() === 'post' && $this->validate($rules))
		{
			$data = [
				'nasname' => $this->request->getPost('nasname'),
				'shortname' => $this->request->getPost('shortname'),
				'type' => $this->request->getPost('type'),
				'ports' => $this->request->getPost('ports'),
				'secret' => $this->request->getPost('secret'),
				'server' => $this->request->getPost('server'),
				'community' => $this->request->getPost('community'),
				'description' => $this->request->getPost('description'),
			];
			
			$this->nas_model->save($data);			
			session()->setFlashdata('msg', 'Data Successfully added.');
			return redirect()->route('nases');
		}
		else
		{
			session()->setFlashdata('validation', $this->validator->getErrors());
			return redirect()->back()->withInput();
		}
	}
	
	public function edit($id)
	{
		$data['nas'] = $nas = $this->nas_model->find($id);
		if(!$nas) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();		
		return view('nas/edit', $data);
	}
	
	public function update($id)
	{
		$rules = [ 'nasname'  => 'required'];
		
		if($this->request->getMethod() === 'put' && $this->validate($rules))
		{
			$data = [
				'nasname' => $this->request->getPost('nasname'),
				'shortname' => $this->request->getPost('shortname'),
				'type' => $this->request->getPost('type'),
				'ports' => $this->request->getPost('ports'),
				'secret' => $this->request->getPost('secret'),
				'server' => $this->request->getPost('server'),
				'community' => $this->request->getPost('community'),
				'description' => $this->request->getPost('description'),
			];
			
			$this->nas_model->update($id, $data);
			session()->setFlashdata('msg', 'Data updated successfully.');
			return redirect()->to(route_to('nases'));
		}
		else
		{
			session()->setFlashdata('validation', $this->validator->getErrors());
			return redirect()->back()->withInput();
		}
	}
	
	public function delete()
	{
		$id = $this->request->getGet('id');
		$this->nas_model->delete($id);
		
		session()->setFlashdata('msg', 'Data Successfully deleted');
		return redirect()->route('nases');
	}
}
