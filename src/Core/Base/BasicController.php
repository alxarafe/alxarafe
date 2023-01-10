<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Base;

use Alxarafe\Core\Helpers\Globals;

/**
 * Class BasicController
 *
 * Define el controlador básico.
 * No requiere uso de base de datos ni de autenticación.
 *
 * @author  Rafael San José Tovar <info@rsanjoseo.com>
 * @version 2023.0108
 *
 * @package Alxarafe\Core\Base
 */
abstract class BasicController
{
    /**
     * Indica si hay que proteger la edición de la salida o cierre accidental del navegador.
     * Si true, se necesita pulsar el botón aceptar o cancelar, o confirmar el cierre.
     *
     * @var bool
     */
    public bool $protectedClose;

    /**
     * Contiene la acción a ejecutar por el controlador o null, si no hay acción.
     *
     * @var string|null
     */
    public ?string $action;

    /**
     * Indica si hay o no menú que mostrar.
     * Los controladores básicos no usan menú.
     *
     * @var bool
     */
    public bool $hasMenu = false;

    /**
     * Contiene una instancia de la clase View o nulo si no ha sido asignada.
     *
     * @var View
     */
    public View $view;

    /**
     * BasicController constructor
     */
    public function __construct()
    {
        // parent::__construct();

        $this->protectedClose = false;
        if (!$this->preLoad()) {
            trigger_error('preLoad fails!');
        }
    }

    /**
     * Realiza la carga inicial de variables del controlador.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2023.0108
     *
     * @return bool
     */
    public function preLoad(): bool
    {
        $this->action = filter_input(INPUT_POST, 'action');
        return true;
    }

    /**
     * Forma la ruta para recargar usando el mismo módulo y controlador, ignorando
     * el resto de variables GET.
     *
     * @param string $module
     * @param string $controller
     *
     * @return string
     */
    public static function url(string $module = Globals::DEFAULT_MODULE_NAME, string $controller = Globals::DEFAULT_CONTROLLER_NAME): string
    {
        return BASE_URI . '?' . Globals::MODULE_GET_VAR . '=' . $module . '&' . Globals::CONTROLLER_GET_VAR . '=' . $controller;
    }

    /**
     * Punto de entrada del controlador.
     * El dispatcher:
     * - En primer lugar instancia (carga el controlador y se ejecuta el __construct)
     * - Y a continuación, lanza el método indicado, por defecto es main()
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2023.0108
     *
     * @return bool
     */
    public function main(): bool
    {
        $result = true;
        if (isset($this->action)) {
            $result = $this->doAction();
        }
        $this->view = $this->setView();
        return $result;
    }

    /**
     * Ejecuta una acción
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2023.0108
     *
     * @return bool
     */
    public function doAction(): bool
    {
        switch ($this->action) {
            case 'save':
                return $this->doSave();
            case 'exit':
                $this->doExit();
                break;
            default:
                trigger_error("The '$this->action' action has not been defined!");
        }
        return true;
    }

    /**
     * Guarda los cambios. Por defecto no hace nada, hay que sobreescribirlo.
     * TODO: Analizar si puede convenir que sea un método abstracto.
     *       Podría ser un método abstracto, pero es posible que no sea necesario.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2023.0108
     *
     * @return bool
     */
    public function doSave(): bool
    {
        return true;
    }

    /**
     * Regresa a la pantalla principal.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2023.0108
     *
     */
    public function doExit(): void
    {
        header('Location: ' . BASE_URI);
        die();
    }

    /**
     * Retorna una instancia de la vista.
     * TODO: Analizar si es necesario tener las vistas por separado o si es preferible
     *       definir todos los métodos en el controlador para simplificar.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2023.0108
     *
     * @return View
     */
    abstract public function setView(): View;
}
