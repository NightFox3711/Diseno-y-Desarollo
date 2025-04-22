<?php
include_once '../Model/Database.php';
include_once '../Model/OfertasModel.php';


function obtenerOfertas($searchTerm = '') {
    return listarOfertas($searchTerm);
}