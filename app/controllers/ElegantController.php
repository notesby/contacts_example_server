<?php
	class ElegantController extends Controller 
	{
		public function elegantSimpleInsert($modelName, $modelData = null)
		{
			$model = new $modelName;
			$modelPK = $model->getKeyName();

			if($modelData)
				$new = $modelData;
			else
				$new = Request::only($model->getFillable());

			if(array_key_exists($modelPK, $new))
			{
				$model = $model::where($modelPK,'=',$new[$modelPK])->first();
				if(!$model)
					return array('error'=>true,'message'=>Lang::get('messages.error_not_found'),'data'=>'');
			}

			if($model->validate($new,$model->$modelPK))
			{
				$model = $model->inputer($model,$new);
				if(!$model->save())
					return array('error'=>true,'message'=>Lang::get('messages.error_save'),'data'=>'');
				else
					return array('error'=>false,'message'=>Lang::get('messages.saved'),'data'=>'');
			}
			else
			{
				$errors = $model->errors();
				return array('error'=>true,'message'=>Lang::get('messages.error_save').$errors,'data'=>'');
			}
		}
	}
?>