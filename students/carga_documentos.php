<?php
require_once '../config/conexion.php';
require_once 'controllers/CargaDocumentosController.php';

$controller = new CargaDocumentosController($conexion);
$controller->index();
