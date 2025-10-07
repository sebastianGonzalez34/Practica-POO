<?php
// Mostrar errores en desarrollo (puedes desactivar en producción)
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Práctica POO</title>
    <!-- Usa ruta relativa (misma carpeta) -->
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <div class="container">
        <header>
            <h1>Práctica de POO</h1>
            <p>Ing. Irina Fong</p>
        </header>

        <?php
        echo "<!-- PHP está funcionando -->";

        // ====== Clases de Figuras Geométricas ======
        abstract class Figura {
            abstract public function calcularArea();
            abstract public function calcularPerimetro();
        }

        class Rectangulo extends Figura {
            private float $base;
            private float $altura;

            public function __construct(float $base, float $altura) {
                $this->base = $base;
                $this->altura = $altura;
            }
            public function calcularArea(): float { return $this->base * $this->altura; }
            public function calcularPerimetro(): float { return 2 * ($this->base + $this->altura); }
        }

        class Triangulo extends Figura {
            private float $base;
            private float $altura;
            private float $lado1;
            private float $lado2;
            private float $lado3;

            public function __construct(float $base, float $altura, float $lado1, float $lado2, float $lado3) {
                $this->base  = $base;
                $this->altura= $altura;
                $this->lado1 = $lado1;
                $this->lado2 = $lado2;
                $this->lado3 = $lado3;
            }
            public function calcularArea(): float { return ($this->base * $this->altura) / 2; }
            public function calcularPerimetro(): float { return $this->lado1 + $this->lado2 + $this->lado3; }
        }

        class Circulo extends Figura {
            private float $radio;

            public function __construct(float $radio) { $this->radio = $radio; }
            public function calcularArea(): float { return round(pi() * pow($this->radio, 2), 2); }
            public function calcularPerimetro(): float { return round(2 * pi() * $this->radio, 2); }
        }

        // ====== Interfaz y clases para Saludos ======
        interface Saludo {
            public function saludar(): string;
            public function despedir(): string;
            public function saludarPersonalizado(string $nombre): string;
            public function despedirPersonalizado(string $nombre): string;
        }

        class SaludoEspanol implements Saludo {
            public function saludar(): string { return "¡Hola! ¿Cómo estás?"; }
            public function despedir(): string { return "¡Adiós! Que tengas un buen día."; }
            public function saludarPersonalizado(string $nombre): string { return "¡Hola $nombre! ¿Cómo estás?"; }
            public function despedirPersonalizado(string $nombre): string { return "¡Adiós $nombre! Que tengas un excelente día."; }
        }

        class SaludoIngles implements Saludo {
            public function saludar(): string { return "Hello! How are you?"; }
            public function despedir(): string { return "Goodbye! Have a nice day."; }
            public function saludarPersonalizado(string $nombre): string { return "Hello $nombre! How are you?"; }
            public function despedirPersonalizado(string $nombre): string { return "Goodbye $nombre! Have a wonderful day."; }
        }

        // ====== Instancias de ejemplo (figuras) ======
        $rectangulo = new Rectangulo(5, 3);
        $triangulo  = new Triangulo(4, 6, 5, 5, 5);
        $circulo    = new Circulo(7);

        // ====== Manejo del formulario de Saludo Personalizado ======
        $resultadoSaludo = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
            $nombre = $nombre === '' ? 'Invitado' : htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8');
            $idioma = $_POST['idioma'] ?? 'es';

            $saludo = ($idioma === 'en') ? new SaludoIngles() : new SaludoEspanol();

            $resultadoSaludo = "<div class='resultado'>
                <p><strong>Saludo:</strong> {$saludo->saludarPersonalizado($nombre)}</p>
                <p><strong>Despedida:</strong> {$saludo->despedirPersonalizado($nombre)}</p>
            </div>";
        }
        ?>

        <section class="figuras-geometricas">
            <h2>Problema #1 - Figuras Geométricas</h2>
            <div class="figuras">
                <div class="card">
                    <h3>Rectángulo</h3>
                    <p><strong>Base:</strong> 5 unidades</p>
                    <p><strong>Altura:</strong> 3 unidades</p>
                    <p><strong>Área:</strong> <?php echo $rectangulo->calcularArea(); ?> u²</p>
                    <p><strong>Perímetro:</strong> <?php echo $rectangulo->calcularPerimetro(); ?> u</p>
                </div>

                <div class="card">
                    <h3>Triángulo</h3>
                    <p><strong>Base:</strong> 4 unidades</p>
                    <p><strong>Altura:</strong> 6 unidades</p>
                    <p><strong>Lados:</strong> 5, 5, 5 u</p>
                    <p><strong>Área:</strong> <?php echo $triangulo->calcularArea(); ?> u²</p>
                    <p><strong>Perímetro:</strong> <?php echo $triangulo->calcularPerimetro(); ?> u</p>
                </div>

                <div class="card">
                    <h3>Círculo</h3>
                    <p><strong>Radio:</strong> 7 unidades</p>
                    <p><strong>Área:</strong> <?php echo $circulo->calcularArea(); ?> u²</p>
                    <p><strong>Perímetro:</strong> <?php echo $circulo->calcularPerimetro(); ?> u</p>
                </div>
            </div>
        </section>

        <section class="sistema-saludos">
            <h2>Sistema de Saludos Multidioma</h2>

            <div class="saludos">
                <div class="card">
                    <h3>Saludo en Español</h3>
                    <p><?php echo (new SaludoEspanol())->saludar(); ?></p>
                    <p><?php echo (new SaludoEspanol())->despedir(); ?></p>
                </div>

                <div class="card">
                    <h3>Saludo en Inglés</h3>
                    <p><?php echo (new SaludoIngles())->saludar(); ?></p>
                    <p><?php echo (new SaludoIngles())->despedir(); ?></p>
                </div>
            </div>

            <div class="saludo-personalizado">
                <h3>Saludo Personalizado</h3>
                <form method="POST" action="">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required />

                    <label for="idioma">Idioma:</label>
                    <select id="idioma" name="idioma">
                        <option value="es">Español</option>
                        <option value="en">Inglés</option>
                    </select>

                    <button type="submit">Saludar</button>
                </form>

                <?php
                    // imprime el resultado del POST si existe
                    if ($resultadoSaludo !== '') {
                        echo $resultadoSaludo;
                    }
                ?>
            </div>
        </section>

        <footer>
            <small>POO en PHP • Ejemplo académico</small>
        </footer>
    </div>
</body>
</html>
