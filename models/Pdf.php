<?php

namespace Model;

class Pdf extends ActiveRecord {
    protected static $tabla = 'pdf';
    protected static $columnasDB = ['id', 'documento', 'nombre', 'fecha', 'notas'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->documento = $args['documento'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->fecha = $args['fecha'] ?? '';
        $this->notas = $args['notas'] ?? '';
    }

    // Validación 
    public function validar_pdf() {
        if(!$this->documento) {
            self::$alertas['error'][] = 'Tienes que adjuntar un documento';
        }
        if(!$this->nombre) {
            self::$alertas['error'][] = 'Tienes que añadir una semana al documento';
        }
        if(!$this->fecha) {
            self::$alertas['error'][] = 'Tienes que indicar la fecha a la que corresponde el planning';
        }
        return self::$alertas;
    }

    public static function descargar_entrenamiento()
    {
        if(isset($_GET['nombre_archivo'])) {
            // Ruta al archivo PDF en el servidor
            $rutaArchivo = '../public/entrenamientos/' . $_GET['nombre_archivo'] . '.pdf';

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