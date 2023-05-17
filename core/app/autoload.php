<?php
// autoload.php
// [created] 10 octubre 
// [rebuilded] 9 abril 
// esta funcion elimina el hecho de estar agregando los modelos manualmente


function my_autoload($modelname){
	if(Model::exists($modelname)){
		include Model::getFullPath($modelname);
	} 
}

spl_autoload_register('my_autoload');


?>