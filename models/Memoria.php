<?php

namespace Model;

class Memoria extends ActiveRecord {
    protected static $tabla = 'memoria';
    protected static $columnasDB = ['id', 'documento', 'fecha'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->documento = $args['documento'] ?? '';
        $this->fecha = $args['fecha'] ?? '';
    }

    // Validación 
    public function validar_memoria() {
        if(!$this->documento) {
            self::$alertas['error'][] = 'Tienes que adjuntar un documento';
        }
        if(!$this->fecha) {
            self::$alertas['error'][] = 'Tienes que indicar la temporada a la que corresponde la memoria';
        }
        return self::$alertas;
    }

    public static function descargar_memoria()
    {
        if(isset($_GET['nombre_archivo'])) {
            // Ruta al archivo PDF en el servidor
            $rutaArchivo = '../public/memorias_economicas/' . $_GET['nombre_archivo'] . '.pdf';

            // Verifica si el archivo existe
            if(file_exists($rutaArchivo)) {
                // Configura los encabezados para la descarga
                header('Content-Type: application/pdf');
                header('Content-Disposition: attachment; filename="' . $_GET['nombre_archivo'] . '.pdf"');
                header('Content-Length: ' . filesize($rutaArchivo));

                // Lee y envía el contenido del archivo
                readfile($rutaArchivo);
                exit;
            } else {
                // Manejar el error si el archivo no existe
                echo "El archivo no existe.";
            }
        }
    }
}