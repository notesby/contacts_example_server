<?php
	class ContactController extends ElegantController 
	{
		public function Insert()
		{
			$fields = Input::only('first_name','last_name','phone','birthdate','zip_code');

			$contact = new Contact();

			if ($contact->validate($fields)) 
			{
				$contact = $contact->inputer($contact,$fields);
				if (!$contact->save()) 
				{
					return array('error'=>true,'message'=>'contact not found','data'=>'');
				}

				return array('error'=>false,'message'=>'contact saved','data'=>'');
			}

			$errors = $contact->errors();

			return array('error'=>true,'message'=>'unable to save contact: '.$errors,'data'=>'');
		}

		public function Update()
		{
			if (Input::has('id')) 
			{
				$fields = Input::only('first_name','last_name','phone','birthdate','zip_code');

				$contact = Contact::find(Input::get('id'));

				if (!$contact) 
				{
					return array('error'=>true,'message'=>'contact not found','data'=>'');
				}

				if ($contact->validate($fields)) 
				{
					$contact = $contact->inputer($contact,$fields);

					if (!$contact->save()) 
					{
						return array('error'=>true,'message'=>'unable to save contact: internal error','data'=>'');
					}

					return array('error'=>false,'message'=>'contact saved','data'=>'');
				}

				$errors = $contact->errors();

				return array('error'=>true,'message'=>'unable to save contact: '.$errors,'data'=>'');
			}

			return array('error'=>true,'message'=>'please provide an id','data'=>'');
		}

		public function Delete()
		{
			if (Input::has('id')) 
			{
				$contact = Contact::find(Input::get('id'));

				if(!$contact)
				{
					return array('error'=>true,'message'=>'contact not found','data'=>'');
				}

				if(!$contact->delete())
				{
					return array('error'=>true,'message'=>'unable to delete contact','data'=>'');
				}

				return array('error'=>false,'message'=>'contact deleted','data'=>'');
			}

			return array('error'=>true,'message'=>'please provide an id','data'=>'');
		}

		public function Get()
		{
			if(Input::has('id'))
			{
				$contact = Contact::find(Input::get('id'));

				if (!$contact) 
				{
					return array('error'=>true,'message'=>'data not found','data'=>'');
				}
					
				return array('error'=>false,'message'=>'contact','data'=>$contact);
			}

			return array('error'=>true,'message'=>'please provide an id','data'=>'');
		}

		public function GetAll()
		{
			return array('error'=>false,'message'=>'results','data'=>Contact::all());
		}
	}
?>