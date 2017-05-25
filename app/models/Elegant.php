<?php
	class Elegant extends Eloquent
	{
		protected $rules = array();

		protected $errors;

		public function validate($data,$id=0)
		{
			// make a new validator object
			$messsages = $this->messsages;
			if(!$messsages)
				$messsages = [];
			
			if($id > 0)
				$v = Validator::make($data, $this->rules($id), $messsages);
			else
				$v = Validator::make($data, $this->rules, $messsages);

			// check for failure
			if ($v->fails())
			{
				// set errors and return false
				$this->errors = $v->errors();
				return false;
			}

			// validation pass
			return true;
		}

		public function errors()
		{
			$error = $this->errors->toArray();
			$mensaje = '';
			foreach ($error as $key)
			{
				$mensaje = $mensaje.$key['0'].' ';
			}
			$errors = substr($mensaje,0,-1);
			return $errors;
		}

		public function inputer($model,$data)
		{
			$tmpData = [];
			foreach($data as $key => $value){
				if($value !== '')
					$tmpData[$key] = $value;
				else
					$tmpData[$key] = null;
			}
			$model->fill($tmpData);
			return $model;
		}
	}
?>