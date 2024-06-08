<?php

namespace Saulmoralespa\ServientregaPanama\Tests;

use PHPUnit\Framework\TestCase;
use Dotenv\Dotenv;
use Saulmoralespa\ServientregaPanama\WebService;

class ServientregaTest extends TestCase
{

    public WebService $servientrega;
    protected function setUp(): void
    {
        $dotenv = Dotenv::createMutable(__DIR__ . '/../');
        $dotenv->load();

        $this->servientrega = new WebService(
            $_ENV['USER'],
            $_ENV['PASSWORD']
        );
    }


    public function testQuote()
    {
        $args = array(
            "tipo" => "obtener_tarifa_nacional",
            'ciu_ori' => "24 DE DICIEMBRE",
            'provincia_ori' => "PANAMA",
            'ciu_des' => "BAGALA",
            'provincia_des' => "CHIRIQUI",
            'valor_declarado' => "",
            'peso' => 5,
            'alto' => 20,
            'ancho' => 25,
            'largo' => 30,
            'recoleccion' => '',
            "nombre_producto" => "PREMIER-RESIDENCIAL", //PREMIER-CDS A CDS
        );

        $result = $this->servientrega->quote($args);
        $this->assertIsArray($result);
        $this->assertArrayHasKey('valor_declarado', $result);
    }

    public function testGenerateGuia()
    {
        $parameters = array(
            'nombre_destinatario' => 'Andres Perez',
            'direccion_destinatario' => 'Calle 2 # 30',
            'distrito_destinatario' => 'Distrito del Destinatario',
            'provincia_destinatario' => 'CHIRIQUI',
            'nombre_remite' => 'Saul Morales Pacheco',
            'direccion_remite' => 'calle 3 # 30',
            'distrito_remite' => '',
            'provincia_remite' => 'Panama',
            'servicio' => 'PREMIER-RESIDENCIAL', //PREMIER-CDS A CDS
            'telefono' => '3123123123',
            'peso' => '',
            'piezas' => 1,
            'volumen' => '',
            'contiene' => 'Contiene productos de valor',
            'transporte' => 'TERRESTRE',
            'valor_declarado' => 25,
            'info01' => 'Contiene productos de valor',
            'valor_recaudar' => 0,
            'remision' => '',
            'factura' => 82,
            'observacion' => 'Contiene productos de valor',
            'guia_cliente' => '',
            'latitud' => '',
            'longitud' => '',
            'mail_destinatario' => 'notifications@sag.com',
            'fecha_programacion' => ''
        );

        $result = $this->servientrega->generarGuia($parameters);
        $this->assertIsArray($result);
        $this->assertArrayHasKey('miembro', $result);
        $miembro = $result['miembro'];
        $this->assertArrayHasKey('guia', $miembro);
    }

    public function testTracking()
    {
        $data = [
            "id" => "730015382",
        ];
        $result = $this->servientrega->tracking($data);
        $this->assertArrayHasKey('miembro', $result);
    }
}
