<?php
class ProxyJsonView extends View
{
    public function render($action = null)
    {
        // render content
        $action = is_null($action) ? $this->controller->action : $action;
        if (strpos($action, '/') === false) {
            $view_filename = VIEWS_DIR . $this->controller->name . '/' . $action . self::$ext;
        } else {
            $view_filename = VIEWS_DIR . $action . self::$ext;
        }

        self::extractAndMerge($view_filename, $this->vars);

        header("Content-Type: application/json; charset=utf-8");
        $this->controller->output .= json_encode($this->vars['response']);
    }

    protected static function extractAndMerge($_filename, &$_vars)
    {
        if (!file_exists($_filename)) {
            throw new DCException("{$_filename} is not found");
        }

        extract($_vars, EXTR_SKIP);
        ob_start();
        ob_implicit_flush(0);

        include $_filename;

        $vars = get_defined_vars();
        unset($vars['_filename']);
        unset($vars['_vars']);
        $_vars = $vars;

        return ob_get_clean();
    }
}
