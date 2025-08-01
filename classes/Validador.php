<?php
class Validador {
    protected static $errores = [];

    public static function validar(array $data, array $reglas) {
        self::$errores = [];

        foreach ($reglas as $campo => $reglasCampo) {
            $valor = $data[$campo] ?? null;

            foreach (explode('|', $reglasCampo) as $regla) {
                $regla = trim($regla);

                if ($regla === 'required' && empty($valor) && $valor !== '0') {
                    self::$errores[$campo][] = "El campo $campo es obligatorio.";
                }

                if ($regla === 'email' && !filter_var($valor, FILTER_VALIDATE_EMAIL)) {
                    self::$errores[$campo][] = "El campo $campo debe ser un email válido.";
                }

                if ($regla === 'alpha' && !preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $valor)) {
                    self::$errores[$campo][] = "El campo $campo solo debe contener letras.";
                }

                if ($regla === 'sexo' && !in_array($valor, ['M', 'F'])) {
                    self::$errores[$campo][] = "El campo $campo debe ser 'M' o 'F'.";
                }

                if ($regla === 'boolean' && !in_array($valor, [0, 1, '0', '1'], true)) {
                    self::$errores[$campo][] = "El campo $campo debe ser 0 o 1.";
                }

                if ($regla === 'array' && !is_array($valor)) {
                    self::$errores[$campo][] = "El campo $campo debe tener al menos una opción seleccionada.";
                }

                if ($regla === 'numeric' && !is_numeric($valor)) {
                    self::$errores[$campo][] = "El campo $campo debe ser un valor numérico.";
                }
            }
        }

        return empty(self::$errores);
    }

    public static function errores() {
        return self::$errores;
    }
}

?>