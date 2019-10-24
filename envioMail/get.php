<?php

///////////////////////////INICIO METODOS GET LISTADO////////////////////////////////////

function valirdarcodigo($comercioid,$codigo)
{
	$conn = conectar();
	$sql = "SELECT * from comercio
	where comercioid = " . $comercioid . " and codigoretiro = " . $codigo . ";";

	$resultado=mysqli_query($conn,$sql);

	$count = mysqli_num_rows($resultado);

	if($count > 0)
	{
		return true;
	}
	else {
		return false;
	}
}



function validarusuario($usuario)
{
	$conn = conectar();
	$sql = "SELECT * from usuario where email = '" . $usuario . "';";
	//return $sql;
	$resultado=mysqli_query($conn,$sql);

	$count = mysqli_num_rows($resultado);

	if($count > 0)
	{
		$row = mysqli_fetch_array($resultado);
		$ret = array('usuarioid' => $row['usuarioid'], 'nombre' => $row['nombre']);
	}
	else{
		$ret = array('usuarioid' => 0);
	}

	return $ret;
}

function traermisbarrios($usuarioid)
{
	$conn = conectar();
	$sql = "SELECT * from usuariobarrio ub
	inner join barrio b
	on ub.barrioid = b.barrioid
	where usuarioid = " . $usuarioid . ";";

	$resultado=mysqli_query($conn,$sql);

	$items = array();
	while($row = mysqli_fetch_array($resultado)){
		$items[] = array('barrioid' => $row['barrioid'], 'nombre' => $row['nombre']);
	}

	return $items;
}

function traerdatosusuario($usuarioid)
{
	$conn = conectar();
	$sql = "SELECT * from usuario where usuarioid = " . $usuarioid . ";";

	$resultado=mysqli_query($conn,$sql);

	$items = array();
	while($row = mysqli_fetch_array($resultado)){
		$items[] = array('usuarioid' => $row['usuarioid'], 'nombre' => $row['nombre'], 'apellido' => $row['apellido'],
		'fechanacimiento' => $row['fechanacimiento'], 'genero' => $row['genero'], 'email' => $row['email'],
		'codigopais' => $row['codigopais'], 'telefono' => $row['telefono']);
	}

	return $items;

}

function traernotificaciones($usuarioid)
{
	$conn = conectar();
	$sql = "SELECT * from usuario where usuarioid = " . $usuarioid . ";";

	$resultado=mysqli_query($conn,$sql);

	$items = array();
	while($row = mysqli_fetch_array($resultado)){
		$items[] = array('habilitarnotificaciones' => $row['habilitarnotificaciones'], 'habilitaremail' => $row['habilitaremail'], 'habilitarcomprasaretirar' => $row['habilitarcomprasaretirar']);
	}

	return $items;

}

function busquedabarrios($texto)
{
	$conn = conectar();
	$sql = "SELECT * from barrio where nombre like '%" . $texto . "%';";

	$resultado=mysqli_query($conn,$sql);

	$items = array();
	while($row = mysqli_fetch_array($resultado)){
		$items[] = array('barrioid' => $row['barrioid'], 'nombre' => $row['nombre']);
	}

	return $items;

}

function validarpassword($usuario,$password)
{
	$conn = conectar();
	$sql = "SELECT * from usuario where email = '" . $usuario . "' and password = '" . $password . "';";

	$resultado=mysqli_query($conn,$sql);

	$count = mysqli_num_rows($resultado);

	if($count > 0)
	{
		$row = mysqli_fetch_array($resultado);
		$ret = array('usuarioid' => $row['usuarioid'], 'nombre' => $row['nombre']);
	}
	else{
		$ret = array('usuarioid' => 0);
	}

	return $ret;
}


function traerofertas($usuarioid)
{
	$conn = conectar();
	$sql = "SELECT o.ofertaid, c.comercioid,c.nombre, o.titulo, o.descripcion, cantidad, fechapublicacion,fecharetiro, precio, horariodesde, horariohasta, c.comercioid, zona, direccion, imagen, precioanterior, cf.comerciofavoritoid as favorito
	from oferta o
	inner join comercio c
	on o.comercioid = c.comercioid
	left join comerciofavorito cf
	on c.comercioid = cf.comercioid
	and cf.usuarioid = " . $usuarioid . "
	inner join (SELECT MAX( o.ofertaid ) as ofertaid , c.comercioid
	FROM oferta o
	INNER JOIN comercio c ON o.comercioid = c.comercioid
	GROUP BY c.comercioid) as newtable
	on newtable.ofertaid = o.ofertaid
	group by c.comercioid
	order by o.ofertaid desc;";

	$resultado=mysqli_query($conn,$sql);

	$items = array();
	while($row = mysqli_fetch_array($resultado)){
		$sql3 = "SELECT SUM(cantidad) as cantidadcompras FROM compra where ofertaid = " . $row['ofertaid'] . ";";
		$resultado3=mysqli_query($conn,$sql3);
		$row3 = mysqli_fetch_array($resultado3);
		$cantidadcompradas = $row3["cantidadcompras"];
		$sql2 = "SELECT COUNT(comerciofavoritoid) as cantidadfavoritos FROM comerciofavorito where comercioid = " .$row['comercioid'] . ";";

		$resultado2=mysqli_query($conn,$sql2);
		$row2 = mysqli_fetch_array($resultado2);
		$items[] = array('ofertaid' => $row['ofertaid'], 'titulo' => $row['titulo'], 'descripcion' => $row['descripcion'], 'precio' => $row['precio'], 'horariodesde' => $row['horariodesde'], 'horariohasta' => $row['horariohasta'],
		'cantidad' => $row['cantidad'],'cantidadrestante' => ($row['cantidad'] - $cantidadcompradas), 'fechapublicacion' => $row['fechapublicacion'], 'fecharetiro' => $row['fecharetiro'], 'nombre' => $row['nombre'],'favorito' => $row['favorito'],
		'zona' => $row['zona'], 'direccion' => $row['direccion'], 'imagen' => $row['imagen'], 'cantidadfavoritos' => $row2['cantidadfavoritos'], 'comercioid' => $row['comercioid'],
		'precioanterior' => $row['precioanterior'], 'habilitado' => ($cantidadcompradas < $row['cantidad'] && $row['fecharetiro'] <= DATE()));
	}

	return $items;
}

function traerfavoritos($usuarioid)
{
	$conn = conectar();
	$sql = "SELECT * from oferta o
	inner join comercio c
	on o.comercioid = c.comercioid
	inner join comerciofavorito cf
	on c.comercioid = cf.comercioid
	where cf.usuarioid =  " . $usuarioid . "
	group by c.comercioid;";

	$resultado=mysqli_query($conn,$sql);

	$items = array();
	while($row = mysqli_fetch_array($resultado)){
		$sql2 = "SELECT COUNT(comerciofavoritoid) as cantidadfavoritos FROM comerciofavorito where comercioid = " .$row['comercioid'] . ";";

		$resultado2=mysqli_query($conn,$sql2);
		$row2 = mysqli_fetch_array($resultado2);
		$items[] = array('ofertaid' => $row['ofertaid'], 'cantidadfavoritos' => $row2['cantidadfavoritos'], 'titulo' => $row['titulo'], 'descripcion' => $row['descripcion'], 'precio' => $row['precio'], 'horariodesde' => $row['horariodesde'], 'horariohasta' => $row['horariohasta'], 'cantidad' => $row['cantidad'], 'fechapublicacion' => $row['fechapublicacion'], 'nombre' => $row['nombre'], 'zona' => $row['zona'], 'direccion' => $row['direccion'], 'favorito' => $row['comerciofavoritoid']);
	}

	return $items;
}

function traermiscompras($usuarioid)
{
	$conn = conectar();
	$sql = "SELECT cp.compraid,c.nombre,c.zona, cp.preciototal, c.direccion,o.horariodesde, o.horariohasta,cp.cantidad, cp.retirado, o.fecharetiro, c.codigoretiro, cp.calificacion
	from oferta o
	inner join comercio c
	on o.comercioid = c.comercioid
	inner join compra cp
	on cp.ofertaid = o.ofertaid
	where  cp.usuarioid = " . $usuarioid . ";";

	$resultado=mysqli_query($conn,$sql);

	$items = array();
	while($row = mysqli_fetch_array($resultado)){
		$items[] = array('compraid' => $row['compraid'],'zona' => $row['zona'], 'nombre' => $row['nombre'], 'preciototal' => $row['preciototal'], 'direccion' => $row['direccion'], 'horariodesde' => $row['horariodesde'], 'horariohasta' => $row['horariohasta'], 'cantidad' => $row['cantidad'], 'retirado' => $row['retirado'], 'fecharetiro' => $row['fecharetiro'], 'codigoretiro' => $row['codigoretiro'], 'calificacion' => $row['calificacion']);
	}

	return $items;
}


///////////////////////////FIN METODOS GET LISTADO////////////////////////////////////

?>
