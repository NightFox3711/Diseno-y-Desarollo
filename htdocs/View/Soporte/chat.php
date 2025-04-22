<?php
    include "Bot.php";
    $bot = new Bot;

    $questions = [

        //saludoss
        "hola"                   => "¡Hola! Qué gusto saludarte 😊 ¿En qué puedo ayudarte hoy para que encuentres tu carro ideal",
        "buenas"                     => "¡Hola! Qué gusto saludarte 😊 ¿En qué puedo ayudarte hoy para que encuentres tu carro ideal",
        //despedida
        "adios"                  => "¡Nos vemos pronto!",
        "hasta la proxima"       => "¡Nos vemos pronto!",

        // nombre
        "como te llamas?"        => "Soy MotorsBot. ¿En qué más puedo ayudarte?",
        "cual es tu nombre?"     => "Soy MotorsBot. ¿En qué más puedo ayudarte?",
        "tienes nombre?"         => "Soy MotorsBot. ¿En qué más puedo ayudarte?",
        "tu nombre es?"          => "Mi nombre es " . $bot->getName() . ".",

        //compra Vehiculo 
        "me gustaría comprar un carro" => 
            "¡Excelente decisión! Comprar carro es un paso importante 😄 Tenemos tres marcas disponibles: Toyota, Hyundai y Suzuki. ¿Hay alguna que te llame la atención o te gustaría que te guíe?",
        "si me gustaría saber" =>
            "Perfecto. Tenemos 13 modelos de Toyota, 1 de Hyundai y 1 de Suzuki. ¿Cuál marca prefieres?",

        //comparaciones con todas las "probabilidades"
        "suzuki y hyundai"       => "El Suzuki Vitara 2023 es automático, 4×2, con 29 500 km; el Hyundai Tucson 2017 es automático, 4×2, con 85 000 km. ¿Te ayudo con algo más?",
        "hyundai y suzuki"       => "El Suzuki Vitara 2023 es automático, 4×2, con 29 500 km; el Hyundai Tucson 2017 es automático, 4×2, con 85 000 km. ¿Te ayudo con algo más?",
        "hyundai y toyota"       => "Buena combinación. Toyota tiene 13 modelos: ¿quieres que te los mencione?",
        "toyota y hyundai"       => "Buena combinación. Toyota tiene 13 modelos: ¿quieres que te los mencione?",
        "suzuki y toyota"        => "Excelente elección. Toyota cuenta con 13 modelos. ¿Te gustaría conocerlos?",
        "toyota y suzuki"        => "Excelente elección. Toyota cuenta con 13 modelos. ¿Te gustaría conocerlos?",

        //detalles 
        "si muéstrame las opciones" => 
            "Claro: 
            1. Prado TX 2017  
            2. Corolla Cross 2023  
            3. Land Cruiser 1993  
            4. Rush 2022  
            5. Rush 2023  
            6. Corolla Cross 2023 (versión 2)  
            7. Raize 2023  
            8. Prado TXL 2023  
            9. Rav4 2022  
            10. Fortuner 2020  
            11. Fortuner 2022  
            12. Prado VX 2016  
            13. Hilux 2019  

            Indica el número del modelo que quieres comparar, por ejemplo: “Hyundai - Opción 1”.",

        //Toyota vs. Hyundai
        "hyundai - opción 1"      => "Prado TX 2017: automática, 4×4, 64 000 km. Tucson 2017: automática, 4×2, 85 000 km.",
        "hyundai - opción 2"      => "Corolla Cross 2023: automática, 4×2, 37 000 km. Tucson 2017: automática, 4×2, 85 000 km.",
        "hyundai - opción 3"      => "Land Cruiser 1993: manual, 4×4, 30 000 km. Tucson 2017: automática, 4×2, 85 000 km.",
        "hyundai - opción 4"      => "Rush 2022: automática, 4×2, 64 000 km. Tucson 2017: automática, 4×2, 85 000 km.",
        "hyundai - opción 5"      => "Rush 2023: automática, 4×2, 51 000 km. Tucson 2017: automática, 4×2, 85 000 km.",
        "hyundai - opción 6"      => "Corolla Cross 2023 (v2): automática, 4×2, 39 000 km. Tucson 2017: automática, 4×2, 85 000 km.",
        "hyundai - opción 7"      => "Raize 2023: manual, 4×2, 14 000 km. Tucson 2017: automática, 4×2, 85 000 km.",
        "hyundai - opción 8"      => "Prado TXL 2023: automática, 4×4, 32 000 km. Tucson 2017: automática, 4×2, 85 000 km.",
        "hyundai - opción 9"      => "Rav4 2022: automática, 4×4, 41 000 km. Tucson 2017: automática, 4×2, 85 000 km.",
        "hyundai - opción 10"     => "Fortuner 2020: automática, 4×4, 64 000 km. Tucson 2017: automática, 4×2, 85 000 km.",
        "hyundai - opción 11"     => "Fortuner 2022: automática, 4×4, 48 000 km. Tucson 2017: automática, 4×2, 85 000 km.",
        "hyundai - opción 12"     => "Prado VX 2016: automática, 4×4, 72 000 km. Tucson 2017: automática, 4×2, 85 000 km.",
        "hyundai - opción 13"     => "Hilux 2019: manual, 4×4, 10 400 km. Tucson 2017: automática, 4×2, 85 000 km.",

        //Toyota vs. Suzuki
        "suzuki - opción 1"       => "Prado TX 2017: automática, 4×4, 64 000 km. Vitara 2023: automática, 4×2, 29 500 km.",
        "suzuki - opción 2"       => "Corolla Cross 2023: automática, 4×2, 37 000 km. Vitara 2023: automática, 4×2, 29 500 km.",
        "suzuki - opción 3"       => "Land Cruiser 1993: manual, 4×4, 30 000 km. Vitara 2023: automática, 4×2, 29 500 km.",
        "suzuki - opción 4"       => "Rush 2022: automática, 4×2, 64 000 km. Vitara 2023: automática, 4×2, 29 500 km.",
        "suzuki - opción 5"       => "Rush 2023: automática, 4×2, 51 000 km. Vitara 2023: automática, 4×2, 29 500 km.",
        "suzuki - opción 6"       => "Corolla Cross 2023: automática, 4×2, 39 000 km. Vitara 2023: automática, 4×2, 29 500 km.",
        "suzuki - opción 7"       => "Raize 2023: manual, 4×2, 14 000 km. Vitara 2023: automática, 4×2, 29 500 km.",
        "suzuki - opción 8"       => "Prado TXL 2023: automática, 4×4, 32 000 km. Vitara 2023: automática, 4×2, 29 500 km.",
        "suzuki - opción 9"       => "Rav4 2022: automática, 4×4, 41 000 km. Vitara 2023: automática, 4×2, 29 500 km.",
        "suzuki - opción 10"      => "Fortuner 2020: automática, 4×4, 64 000 km. Vitara 2023: automática, 4×2, 29 500 km.",
        "suzuki - opción 11"      => "Fortuner 2022: automática, 4×4, 48 000 km. Vitara 2023: automática, 4×2, 29 500 km.",
        "suzuki - opción 12"      => "Prado VX 2016: automática, 4×4, 72 000 km. Vitara 2023: automática, 4×2, 29 500 km.",
        "suzuki - opción 13"      => "Hilux 2019: manual, 4×4, 10 400 km. Vitara 2023: automática, 4×2, 29 500 km.",

        //prueba de manejo
        "me gustaría realizar una prueba de manejo" => "Claro, están disponibles de lun–vie de 9:00 am a 5:00 pm. ¿Quieres saber cómo agendar?",
        //aca esta para llenar fecha y hora
        "si me gustaría recibir información"       => "Solo completa el formulario de la web con vehículo, fecha y hora; recibirás un recordatorio.",
        "quiero agendar una prueba de manejo"      => "Agéndala aquí: <a href='TestDriveView.php' class='btn btn-link'>Prueba de manejo</a>.",
        "quiero solicitar permiso para realizar una prueba de manejo" =>
            "Perfecto, solicita tu permiso aquí: <a href='TestDriveView.php' class='btn btn-link'>Solicitud de prueba</a>.",
        "solicitar permiso para prueba de manejo" =>
            "Entendido. Completa tu solicitud aquí: <a href='TestDriveView.php' class='btn btn-link'>Solicitud de prueba</a>.",

        //hacer lista de documentos para tener HU03 E3
        

        //preguntas frecuentes
        "preguntas frecuentes"   => "¡Claro! Estoy aquí para ayudarte 💬 Puedes preguntarme sobre modelos, financiamiento, pruebas de manejo, garantías, servicio postventa, horarios o seguros. ¿Qué te gustaría saber primero?",
        "modelos"                => "Tenemos Semi Nuevos: Prado TXL 2023, Rav4 2022, Fortuner 2020, Fortuner 2022, Prado VX 2016, Hilux 2019, Rush 2023, Corolla Cross 2023, Raize 2023, Vitara 2023 y Tucson 2017.",
        "financiamiento"         => "Trabajamos con Banco Nacional, Banco Popular, CrediQ y nuestra financiera propia (sujeto a estudio crediticio).",
        "garantías"              => "6 meses o 10 000 km, lo que ocurra primero. Consulta en postventa para más info.",
        "servicio postventa"     => "Ofrecemos mantenimiento, reparaciones y revisiones. Nuestro equipo está listo para ayudarte.",
        "horarios"               => "Lun–Vie 8:00 am–6:00 pm y Sáb 9:00 am–1:00 pm.",
        "seguro"                 => "Contamos con varias opciones de seguro. Consulta coberturas y precios con un asesor.",

        //redirecciones
        "me gustaría ir a ventas"        => "Entra a Ventas aquí: <a href='VentasView.php' class='btn btn-link'>Ventas</a>.",
        "necesito ir a inventario"       => "Consulta Inventario: <a href='InventarioView.php' class='btn btn-link'>Inventario</a>.",
        "quiero ir a cotizaciones"       => "Cotizaciones aquí: <a href='CotizacionView.php' class='btn btn-link'>Cotizaciones</a>.",
        "enseñame las ofertas"           => "Ofertas: <a href='OfertasView.php' class='btn btn-link'>Ofertas</a>.",
        "quiero ir al carrito"           => "Tu carrito: <a href='CartView.php' class='btn btn-link'>Carrito</a>.",
        "ver notificaciones"             => "Notificaciones: <a href='NotificacionesView.php' class='btn btn-link'>Notificaciones</a>.",
        "necesito soporte"               => "Soporte: <a href='SoporteView.php' class='btn btn-link'>Soporte</a>.",


        //solo administradores!!!!
        "quiero gestionar la disponibilidad del inventario" =>
            "Claro. Desde el panel de administración puedes actualizar el estado de cada vehículo "
        . "—disponible, reservado o en mantenimiento— para mantener la plataforma siempre al día. "
        . "Ve a: <a href='AdminInventarioView.php' class='btn btn-link'>Gestión de Inventario</a>.",
        "gestionar disponibilidad inventario" =>
            "Por supuesto. Ingresa al área de administración y en la sección de Inventario podrás activar o "
        . "desactivar vehículos, editar sus datos y garantizar que la información esté siempre actualizada.",

        //consultar asesores 

        "consultar asesores"   => 
            "Nuestros asesores disponibles son:\n"
        . "- Samuel Retana (Ventas Toyota)\n"
        . "- Nicole Chaves  (Financiamiento)\n"
        . "- Mariana Ulate (Servicio Postventa)\n"
        . "- Antony Collado (Pruebas de Manejo)\n\n"
        . "¿En cuál de ellos te gustaría profundizar?",

        "asesores disponibles" => 
            "Aquí tienes la lista de asesores:\n"
        . "• Samuel Retana – Ventas Toyota\n"
        . "• Nicole Chaves – Financiamiento\n"
        . "• Mariana Ulate – Servicio Postventa\n"
        . "• Antony Collado – Pruebas de Manejo\n\n"
        . "Dime el nombre del asesor si quieres más detalles.",

        //detalle de asesores
    "samuel retana" => 
        "samuel Retana es nuestro especialista en Ventas Toyota. Atiende de lunes a viernes de 9 am a 6 pm. "
    . "Puedes escribirle a samuretana2018@gmail.com o llamarlo al  8522 7948.",

    "nicole chaves" => 
        "nicole Chaves maneja todo lo relacionado a financiamiento. Está disponible de lunes a viernes de 8 am a 5 pm. "
    . "Su correo es nicom14505@gmail.com  y su teléfono 8586 1655.",

    "mariana ulate" => 
        "mariana Ulate es experta en Servicio Postventa. Atiende de lunes a sábado de 8 am a 2 pm. "
    . "La contactas en mari.ulatec@gmail.com o al 8727 6326.",

    "antony collado" => 
        "antony Collado gestiona las Pruebas de Manejo. Su horario es de 9 am a 4 pm, lun–vie. "
    . "Puedes escribirle a acollado123456@gmail.com o llamar al 8472 7958.",


    //agradecimiento
        "muchas gracias"        => "¡Con gusto! 😊",


    // input no entendido
        "default" => "Lo siento, no entendí eso 😅. Por favor elige una de estas opciones: Comprar vehículo, Comparar modelos, Ver detalles, Prueba de manejo o Consultar asesores"
        ];
        

        if (isset($_GET['msg'])) {
            $msg = strtolower($_GET['msg']);
            $bot->hears($msg, function (Bot $botty) {
                global $msg, $questions;
        
                if (array_key_exists($msg, $questions)) {
                    $botty->reply($questions[$msg]);
                } else {
                    $botty->reply($questions['default']);
                }
            });
        }
        
