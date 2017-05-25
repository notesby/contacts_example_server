<?php
	class Contact extends Elegant
	{
		protected $table = 'contact';
		protected $primaryKey = 'id';
		public $timestamps = true;
		protected $fillable = array('first_name','last_name','phone','birthdate','zip_code');

		protected $rules = array(
			'first_name' => 'required|min:1|max:100',
			'last_name' => 'required|min:1|max:100',
			'phone' => array('required','min:1','max:15','regex:/^[\d]+$/'),
			'birthdate' => 'date_format:Y-m-d'
		);
	}
?>