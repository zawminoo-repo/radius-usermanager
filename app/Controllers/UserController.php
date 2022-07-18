<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;
use App\Models\Group;
use App\Models\RadCheck;
use App\Models\RadReply;
use App\Models\RadUserGroup;
use CodeIgniter\Pager\PagerRenderer;

class UserController extends BaseController
{
    public function __construct()
	{
		$this->user_model = model(User::class);
		$this->group_model = model(Group::class);
		$this->check_model = model(RadCheck::class);
		$this->reply_model = model(RadReply::class);
		$this->usergroup_model = model(RadUserGroup::class);
	}
	
	//List users.
	public function index()
    {
		$username = $this->request->getGet('username');
		$group = $this->request->getGet('group');
		
		$data['groups'] = $this->user_model->getGroups();
		$data['users'] = $this->user_model->paginateUsers($username, $group);
		$data['pager'] = $this->user_model->pager;
		$data['count_users'] = $this->user_model->countUsers($username, $group);
		
		return view('user/list', $data);
    }
	
	//Show user detail (users, radcheck and radreply table).
	public function show($id)
	{
		$data['user'] = $user = $this->user_model->find($id);
		if(!$user) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
	
		$data['check_attributes'] = $this->check_model->where('username', $user->username)->findAll();
		$data['reply_attributes'] = $this->reply_model->where('username', $user->username)->findAll();
		
		return view('user/detail', $data);
	}
	
	//Show reset password page.
	public function resetPasswd($id)
	{
		$data['user'] = $user = $this->user_model->find($id);
		if(!$user) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		return view('user/reset_passwd', $data);
	}
	
	//Update password.
	public function updatePasswd($id)
	{
		$rules = [
			'password' => 'required|min_length[8]|max_length[50]',
            'cpassword' => 'matches[password]',
		];
		
		if($this->request->getMethod() === 'put' && $this->validate($rules))
		{
			$password = sha1($this->request->getPost('password'));
			$username = $this->request->getPost('username');
			
			$data = [ 'password' => $password ];
			
			$this->user_model->update($id, $data);
			$this->check_model->set('value', $password)->where('username', $username)->update();
			
			session()->setFlashdata('msg', 'Password successfully updated.');
			return redirect()->route('users');
		}
		else
		{
			session()->setFlashdata('validation', $this->validator->getErrors());
			return redirect()->back()->withInput();
		}
	}
	
	//Create new user (users table).
	public function create()
	{
		$data['groups'] = $this->group_model->orderBy('group_name', 'asc')->findAll();
		return view('user/add', $data);
	}
	
	//Store new user (users table).
	public function store()
	{
		$rules = [
			'username'  => 'required|min_length[3]|max_length[50]',
			'password' => 'required|min_length[8]|max_length[50]',
            'cpassword' => 'matches[password]',
            'full_name' => 'required',
		];
		
		if($this->request->getMethod() === 'post' && $this->validate($rules))
		{
			$data = [
				'username' => $this->request->getPost('username'),
				'password' => sha1($this->request->getPost('password')),
				'full_name' => $this->request->getPost('full_name'),
				'group' => $this->request->getPost('group'),
				'email' => $this->request->getPost('email'),
				'description' => $this->request->getPost('description'),
			];

			$check_data = [
				'username' => $this->request->getPost('username'),
				'attribute' => 'SHA-Password',
				'op' => ':=',
				'value' => sha1($this->request->getPost('password')),
			];

			$usergroup_data = [
				'username' => $this->request->getPost('username'),
				'groupname' => $this->request->getPost('group'),
				'priority' => 0,
			];

			$this->user_model->save($data);
			$this->check_model->save($check_data);
			$this->usergroup_model->save($usergroup_data);
			
			session()->setFlashdata('msg', 'Data Successfully added.');
			return redirect()->route('users');
		}
		else
		{
			session()->setFlashdata('validation', $this->validator->getErrors());
			return redirect()->back()->withInput();
		}
	}
	
	//Edit username (users table).
	public function edit($id)
	{
		$data['user'] = $user = $this->user_model->find($id);
		if(!$user) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		
		$data['groups'] = $this->group_model->orderBy('group_name', 'asc')->findAll();
		$data['check_attributes'] = $this->check_model->where('username', $user->username)->findAll();
		$data['reply_attributes'] = $this->reply_model->where('username', $user->username)->findAll();
		
		return view('user/edit', $data);
	}
	
	//Update username (users table).
	public function update($id)
	{
		$rules = [
			'username'  => 'required|min_length[3]|max_length[50]',
            'full_name' => 'required',
		];
		
		if($this->request->getMethod() === 'put' && $this->validate($rules))
		{
			$username = $this->request->getPost('username');
			$groupname = $this->request->getPost('group');
			
			$data = [
				'username' => $username,
				'full_name' => $this->request->getPost('full_name'),
				'group' => $groupname,
				'email' => $this->request->getPost('email'),
				'description' => $this->request->getPost('description'),
			];
			
			$this->user_model->update($id, $data);
			$this->usergroup_model->set('groupname', $groupname)->where('username', $username)->update();

			return redirect()->to(route_to('user_show', $id));
		}
	}
	
	//Delete username.
	public function delete()
	{
		$id = $this->request->getGet('id');
		$this->user_model->delete($id);
		
		session()->setFlashdata('msg', 'Data Successfully deleted');
		return redirect()->route('users');
	}
###############################################################################

//Create new radcheck. $id is for redirect link only.
	public function createUserCheck($id)
	{
		$data['user'] = $this->user_model->find($id);
		return view('user/add_user_check', $data);
	}
	
	//Store new radcheck table. $id is for redirect link only.
	public function storeUserCheck($id)
	{
		$rules = [
			'check_attribute' => 'required',
			'check_op' => 'required',
			'check_value' => 'required',
		];
		
		if($this->request->getMethod() === 'post' && $this->validate($rules))
		{
			$data = [
				'username' => $this->request->getPost('username'),
				'attribute' => $this->request->getPost('check_attribute'),
				'op' => $this->request->getPost('check_op'),
				'value' => $this->request->getPost('check_value'),
			];
			
			$this->check_model->save($data);
			return redirect()->to(route_to('user_show', $id));
		}
		else
		{
			session()->setFlashdata('validation', $this->validator->getErrors());
			return redirect()->back()->withInput();
		}
	}
	
	//Grid update radcheck table.
	public function updateUserCheck()
	{
		$check_id = $this->request->getPost('check_id');
		$check_attribute = $this->request->getPost('check_attribute');
		$check_op = $this->request->getPost('check_op');
		$check_value = $this->request->getPost('check_value');
		
		$user_id = $this->request->getPost('user_id');

		for($x = 0; $x < count($check_id); $x++)
		{
			$data[] = [
				'id' => $check_id[$x],
				'attribute' => $check_attribute[$x],
				'op' => $check_op[$x],
				'value' => $check_value[$x],
			];
		}

		$this->check_model->updateBatch($data, 'id');
		return redirect()->to(route_to('user_show', $user_id));
	}
	
	//Delete radcheck.
	public function deleteUserCheck()
	{
		$id = $this->request->getGet('id');
		$user_id = $this->request->getGet('user_id');
		
		$this->check_model->delete($id);
		return redirect()->to(route_to('user_show', $user_id));
	}
###############################################################################

	//Create new radreply. $id is for redirect link only.
	public function createUserReply($id)
	{
		$data['user'] = $this->user_model->find($id);
		return view('user/add_user_reply', $data);
	}
	
	//Store new radreply table. $id is for redirect link only.
	public function storeUserReply($id)
	{
		$rules = [
			'reply_attribute' => 'required',
			'reply_op' => 'required',
			'reply_value' => 'required',
		];
		
		if($this->request->getMethod() === 'post' && $this->validate($rules))
		{
			$data = [
				'username' => $this->request->getPost('username'),
				'attribute' => $this->request->getPost('reply_attribute'),
				'op' => $this->request->getPost('reply_op'),
				'value' => $this->request->getPost('reply_value'),
			];
			
			$this->reply_model->save($data);
			return redirect()->to(route_to('user_show', $id));
		}
		else
		{
			session()->setFlashdata('validation', $this->validator->getErrors());
			return redirect()->back()->withInput();
		}
	}
	
	//Grid update radreply table.
	public function updateUserReply()
	{
		$reply_id = $this->request->getPost('reply_id');
		$reply_attribute = $this->request->getPost('reply_attribute');
		$reply_op = $this->request->getPost('reply_op');
		$reply_value = $this->request->getPost('reply_value');
		
		$user_id = $this->request->getPost('user_id');

		for($x = 0; $x < count($reply_id); $x++)
		{
			$data[] = [
				'id' => $reply_id[$x],
				'attribute' => $reply_attribute[$x],
				'op' => $reply_op[$x],
				'value' => $reply_value[$x],
			];
		}

		$this->reply_model->updateBatch($data, 'id');
		return redirect()->to(route_to('user_show', $user_id));
	}
	
	//Delete radreply.
	public function deleteUserReply()
	{
		$id = $this->request->getGet('id');
		$user_id = $this->request->getGet('user_id');
		
		$this->reply_model->delete($id);
		return redirect()->to(route_to('user_show', $user_id));
	}
}
