<?php
include "Bot.php";
$bot = new Bot;
$questions = [

    //compra de vehículos
    "me gustaría comprar un carro"=>"Claro actualmente contamos con 3 marcas de carros disponibles, ¿Te gustaría saber cuales son?",
    "si me gustaría saber"=>"Actualmente contamos con vehículos 15 los cuales están distribuidos en las siguientes marcas
    Toyota (13), Hyundai (1) y Suzuki (1), si deseas saber sobre los modelos dime de cual o cuales marcas
    deseas saber los modelos disponibles, ten en cuenta que solo puedes comparar 2 vehículos y de diferentes marcas",

    //Hyundai y Suzuki
    "suzuki y hyundai"=>"Gran elección!, Actualmente tenemos el Suzuki Vitara 2023 el cual es un vehículo automático,
    tiene una tracción de 4x2 y cuenta con 29,500 km.  Luego está el Hyundai Tucson 2017 el cual es un vehículo automático, tiene una 
    tracción de 4x2 y cuenta con 85,000 km.  
    Si deseas información sobre otros vehículos puedes encontrarlo en la pestañana de Ofertas. Puedo
    ayudarte con alguna otra cosa?",

    "hyundai y suzuki"=>"Gran elección!, Actualmente tenemos el Suzuki Vitara 2023 el cual es un vehículo automático,
    tiene una tracción de 4x2 y cuenta con 29,500 km.  Luego está el Hyundai Tucson 2017 el cual es un vehículo automático, tiene una 
    tracción de 4x2 y cuenta con 85,000 km.  
    Si deseas información sobre otros vehículos puedes encontrarlo en la pestañana de Ofertas. Puedo
    ayudarte con alguna otra cosa?", 

    //Hyundai y Toyota
    "hyundai y toyota", "toyota y hyundai"=>"Gran elección!, recuerda que de la marca Toyota tenemos 13 modelos, ¿deseas saber las opciones? ",
    "si muéstrame las opciones"=>"De acuerdo, tenemos los siguientes modelos : 1. Toyota Prado TX 2017, 2. Toyota Corolla Cross 2023, 
    3. Toyota Land Cruiser 1993, 4. Toyota Rush 2022, 5. Toyota Rush 2023, 6. Toyota Corolla Cross 2023, 7. Toyota Raize 2023, 8. Toyota Prado TXL 2023,
    9. Toyota Rav4 2022, 10. Toyota Fortuner 2020, 11. Toyota Fortuner 2022, 12. Toyota Prado VX 2016, 13. Toyota Hilux 2019. Con la siguiente frase 
    puedes indicar cuales vehículos deseas comparar : Hyundai - Opción # (número de opción) ",

    //1. Toyota Prado TX 2017
    "hyundai - opción 1"=>"La Toyota Prado TX 2017 es un vehículo automático, posee una tracción 4x4 y cuenta con 
    64,000 km. Mientras que el Hyundai Tucson 2017 es un vehículo automático, tiene una tracción de 4x2 y cuenta con 85,000 km.  
    Si deseas información sobre otros vehículos puedes encontrarlo en la pestañana de Ofertas. Puedo
    ayudarte con alguna otra cosa?",
    
    //2. Toyota Corolla Cross 2023
    "hyundai - opción 2"=>"La Toyota Corolla Cross 2023 es un vehículo automático, posee una tracción 4x2 y cuenta con 
    37,000 km. Mientras que el Hyundai Tucson 2017 es un vehículo automático, tiene una tracción de 4x2 y cuenta con 85,000 km.  
    Si deseas información sobre otros vehículos puedes encontrarlo en la pestañana de Ofertas. Puedo
    ayudarte con alguna otra cosa?",

    //3. Toyota Land Cruiser 1993
    "hyundai - opción 3"=>"La Toyota Land Cruiser 1993 es un vehículo manual, posee una tracción 4x4 y cuenta con 
    30,000 km. Mientras que el Hyundai Tucson 2017 es un vehículo automático, tiene una tracción de 4x2 y cuenta con 85,000 km.  
    Si deseas información sobre otros vehículos puedes encontrarlo en la pestañana de Ofertas. Puedo
    ayudarte con alguna otra cosa?",

    //4. Toyota Rush 2022
    "hyundai - opción 4"=>"La Toyota Rush 2022 es un vehículo automático, posee una tracción 4x2 y cuenta con 
    64,000 km. Mientras que el Hyundai Tucson 2017 es un vehículo automático, tiene una tracción de 4x2 y cuenta con 85,000 km.  
    Si deseas información sobre otros vehículos puedes encontrarlo en la pestañana de Ofertas. Puedo
    ayudarte con alguna otra cosa?",

    //5. Toyota Rush 2023
    "hyundai - opción 5"=>"La Toyota Rush 2023 es un vehículo automático, posee una tracción 4x2 y cuenta con 
    51,000 km. Mientras que el Hyundai Tucson 2017 es un vehículo automático, tiene una tracción de 4x2 y cuenta con 85,000 km.  
    Si deseas información sobre otros vehículos puedes encontrarlo en la pestañana de Ofertas. Puedo
    ayudarte con alguna otra cosa?",

    //6. Toyota Corolla Cross 2023
    "hyundai - opción 6"=>"La Toyota Corolla Cross 2023 es un vehículo automático, posee una tracción 4x2 y cuenta con 
    39,000 km. Mientras que el Hyundai Tucson 2017 es un vehículo automático, tiene una tracción de 4x2 y cuenta con 85,000 km.  
    Si deseas información sobre otros vehículos puedes encontrarlo en la pestañana de Ofertas. Puedo
    ayudarte con alguna otra cosa?",

    //7. Toyota Raize 2023
    "hyundai - opción 7"=>"La Toyota Raize 2023 es un vehículo manual, posee una tracción 4x2 y cuenta con 
    14,000 km. Mientras que el Hyundai Tucson 2017 es un vehículo automático, tiene una tracción de 4x2 y cuenta con 85,000 km.  
    Si deseas información sobre otros vehículos puedes encontrarlo en la pestañana de Ofertas. Puedo
    ayudarte con alguna otra cosa?",

    //8. Toyota Prado TXL 2023
    "hyundai - opción 8"=>"La Toyota Prado TXL 2023 es un vehículo automático, posee una tracción 4x4 y cuenta con 
    32,000 km. Mientras que el Hyundai Tucson 2017 es un vehículo automático, tiene una tracción de 4x2 y cuenta con 85,000 km.  
    Si deseas información sobre otros vehículos puedes encontrarlo en la pestañana de Ofertas. Puedo
    ayudarte con alguna otra cosa?",

    //9. Toyota Rav4 2022
    "hyundai - opción 9"=>"La Toyota Rav4 2022 es un vehículo automático, posee una tracción 4x4 y cuenta con 
    41,000 km. Mientras que el Hyundai Tucson 2017 es un vehículo automático, tiene una tracción de 4x2 y cuenta con 85,000 km.  
    Si deseas información sobre otros vehículos puedes encontrarlo en la pestañana de Ofertas. Puedo
    ayudarte con alguna otra cosa?",

    //10. Toyota Fortuner 2020
    "hyundai - opción 10"=>"La Toyota Fortuner 2020 es un vehículo automático, posee una tracción 4x4 y cuenta con 
    64,000 km. Mientras que el Hyundai Tucson 2017 es un vehículo automático, tiene una tracción de 4x2 y cuenta con 85,000 km.  
    Si deseas información sobre otros vehículos puedes encontrarlo en la pestañana de Ofertas. Puedo
    ayudarte con alguna otra cosa?",

    //11. Toyota Fortuner 2022
    "hyundai - opción 11"=>"La Toyota Fortuner 2022 es un vehículo automático, posee una tracción 4x4 y cuenta con 
    48,000 km. Mientras que el Hyundai Tucson 2017 es un vehículo automático, tiene una tracción de 4x2 y cuenta con 85,000 km.  
    Si deseas información sobre otros vehículos puedes encontrarlo en la pestañana de Ofertas. Puedo
    ayudarte con alguna otra cosa?",

    //12. Toyota Prado VX 2016
    "hyundai - opción 12"=>"La Toyota Prado VX 2016 es un vehículo automático, posee una tracción 4x4 y cuenta con 
    72,000 km. Mientras que el Hyundai Tucson 2017 es un vehículo automático, tiene una tracción de 4x2 y cuenta con 85,000 km.  
    Si deseas información sobre otros vehículos puedes encontrarlo en la pestañana de Ofertas. Puedo
    ayudarte con alguna otra cosa?",

    //13. Toyota Hilux 2019
    "hyundai - opción 13"=>"La Toyota Hilux 2019 es un vehículo manual, posee una tracción 4x4 y cuenta con 
    10,400 km. Mientras que el Hyundai Tucson 2017 es un vehículo automático, tiene una tracción de 4x2 y cuenta con 85,000 km.  
    Si deseas información sobre otros vehículos puedes encontrarlo en la pestañana de Ofertas. Puedo
    ayudarte con alguna otra cosa?",

    //Suzuki y Toyota
     "suzuki y toyota", "toyota y suzuki"=>"Gran elección!, recuerda que de la marca Toyota tenemos 13 modelos, ¿deseas saber las opciones? ",
     "si muéstrame los modelos"=>"De acuerdo, tenemos los siguientes modelos : 1. Toyota Prado TX 2017, 2. Toyota Corolla Cross 2023, 
     3. Toyota Land Cruiser 1993, 4. Toyota Rush 2022, 5. Toyota Rush 2023, 6. Toyota Corolla Cross 2023, 7. Toyota Raize 2023, 8. Toyota Prado TXL 2023,
     9. Toyota Rav4 2022, 10. Toyota Fortuner 2020, 11. Toyota Fortuner 2022, 12. Toyota Prado VX 2016, 13. Toyota Hilux 2019. Con la siguiente frase 
     puedes indicar cuales vehículos deseas comparar : Suzuki - Opción # (número de opción) ",

    //1. Toyota Prado TX 2017
    "suzuki - opción 1"=>"La Toyota Prado TX 2017 es un vehículo automático, posee una tracción 4x4 y cuenta con 
    64,000 km. Mientras que el Suzuki Vitara 2023 el cual es un vehículo automático,tiene una tracción de 4x2 y cuenta con 29,500 km.  
    Si deseas información sobre otros vehículos puedes encontrarlo en la pestañana de Ofertas. Puedo
    ayudarte con alguna otra cosa?",
    
    //2. Toyota Corolla Cross 2023
    "suzuki - opción 2"=>"La Toyota Corolla Cross 2023 es un vehículo automático, posee una tracción 4x2 y cuenta con 
    37,000 km. Mientras que el Suzuki Vitara 2023 el cual es un vehículo automático,tiene una tracción de 4x2 y cuenta con 29,500 km.  
    Si deseas información sobre otros vehículos puedes encontrarlo en la pestañana de Ofertas. Puedo
    ayudarte con alguna otra cosa?",

    //3. Toyota Land Cruiser 1993
    "suzuki - opción 3"=>"La Toyota Land Cruiser 1993 es un vehículo manual, posee una tracción 4x4 y cuenta con 
    30,000 km. Mientras que el Suzuki Vitara 2023 el cual es un vehículo automático,tiene una tracción de 4x2 y cuenta con 29,500 km. 
    Si deseas información sobre otros vehículos puedes encontrarlo en la pestañana de Ofertas. Puedo
    ayudarte con alguna otra cosa?",

    //4. Toyota Rush 2022
    "suzuki - opción 4"=>"La Toyota Rush 2022 es un vehículo automático, posee una tracción 4x2 y cuenta con 
    64,000 km. Mientras que el Suzuki Vitara 2023 el cual es un vehículo automático,tiene una tracción de 4x2 y cuenta con 29,500 km. 
    Si deseas información sobre otros vehículos puedes encontrarlo en la pestañana de Ofertas. Puedo
    ayudarte con alguna otra cosa?",

    //5. Toyota Rush 2023
    "suzuki - opción 5"=>"La Toyota Rush 2023 es un vehículo automático, posee una tracción 4x2 y cuenta con 
    51,000 km. Mientras que el Suzuki Vitara 2023 el cual es un vehículo automático,tiene una tracción de 4x2 y cuenta con 29,500 km.  
    Si deseas información sobre otros vehículos puedes encontrarlo en la pestañana de Ofertas. Puedo
    ayudarte con alguna otra cosa?",

    //6. Toyota Corolla Cross 2023
    "suzuki - opción 6"=>"La Toyota Corolla Cross 2023 es un vehículo automático, posee una tracción 4x2 y cuenta con 
    39,000 km. Mientras que el Suzuki Vitara 2023 el cual es un vehículo automático,tiene una tracción de 4x2 y cuenta con 29,500 km.  
    Si deseas información sobre otros vehículos puedes encontrarlo en la pestañana de Ofertas. Puedo
    ayudarte con alguna otra cosa?",

    //7. Toyota Raize 2023
    "suzuki - opción 7"=>"La Toyota Raize 2023 es un vehículo manual, posee una tracción 4x2 y cuenta con 
    14,000 km. Mientras que el Suzuki Vitara 2023 el cual es un vehículo automático,tiene una tracción de 4x2 y cuenta con 29,500 km.  
    Si deseas información sobre otros vehículos puedes encontrarlo en la pestañana de Ofertas. Puedo
    ayudarte con alguna otra cosa?",

    //8. Toyota Prado TXL 2023
    "suzuki - opción 8"=>"La Toyota Prado TXL 2023 es un vehículo automático, posee una tracción 4x4 y cuenta con 
    32,000 km. Mientras que el Suzuki Vitara 2023 el cual es un vehículo automático,tiene una tracción de 4x2 y cuenta con 29,500 km.  
    Si deseas información sobre otros vehículos puedes encontrarlo en la pestañana de Ofertas. Puedo
    ayudarte con alguna otra cosa?",

    //9. Toyota Rav4 2022
    "suzuki - opción 9"=>"La Toyota Rav4 2022 es un vehículo automático, posee una tracción 4x4 y cuenta con 
    41,000 km. Mientras que el Suzuki Vitara 2023 el cual es un vehículo automático,tiene una tracción de 4x2 y cuenta con 29,500 km.  
    Si deseas información sobre otros vehículos puedes encontrarlo en la pestañana de Ofertas. Puedo
    ayudarte con alguna otra cosa?",

    //10. Toyota Fortuner 2020
    "suzuki - opción 10"=>"La Toyota Fortuner 2020 es un vehículo automático, posee una tracción 4x4 y cuenta con 
    64,000 km. Mientras que el Suzuki Vitara 2023 el cual es un vehículo automático,tiene una tracción de 4x2 y cuenta con 29,500 km.  
    Si deseas información sobre otros vehículos puedes encontrarlo en la pestañana de Ofertas. Puedo
    ayudarte con alguna otra cosa?",

    //11. Toyota Fortuner 2022
    "suzuki - opción 11"=>"La Toyota Fortuner 2022 es un vehículo automático, posee una tracción 4x4 y cuenta con 
    48,000 km. Mientras que el Suzuki Vitara 2023 el cual es un vehículo automático,tiene una tracción de 4x2 y cuenta con 29,500 km.  
    Si deseas información sobre otros vehículos puedes encontrarlo en la pestañana de Ofertas. Puedo
    ayudarte con alguna otra cosa?",

    //12. Toyota Prado VX 2016
    "suzuki - opción 12"=>"La Toyota Prado VX 2016 es un vehículo automático, posee una tracción 4x4 y cuenta con 
    72,000 km. Mientras que el Suzuki Vitara 2023 el cual es un vehículo automático,tiene una tracción de 4x2 y cuenta con 29,500 km.  
    Si deseas información sobre otros vehículos puedes encontrarlo en la pestañana de Ofertas. Puedo
    ayudarte con alguna otra cosa?",

    //13. Toyota Hilux 2019
    "suzuki - opción 13"=>"La Toyota Hilux 2019 es un vehículo manual, posee una tracción 4x4 y cuenta con 
    10,400 km. Mientras que el Suzuki Vitara 2023 el cual es un vehículo automático,tiene una tracción de 4x2 y cuenta con 29,500 km.  
    Si deseas información sobre otros vehículos puedes encontrarlo en la pestañana de Ofertas. Puedo
    ayudarte con alguna otra cosa?",

    //Prueba de manejo
    "me gustaría realizar una prueba de manejo"=>"De acuerdo, ¿Te gustaría tener información sobre el proceso para agendar una prueba de manejo?",
    "si me gustaría recibir información"=>"De acuerdo, las pruebas de manejo se realizan en un horario de lunes a viernes entre las 9:00 am a 
    5:00 pm. Agendas tu cita mediante nuestro formulario que se encuentra en la barra de navegación, seleccionas el vehículo junto a la 
    fecha y hora que sea más conveniente para ti siempre y cuando estén disponibles la hora y fecha que hayas elegido, por último una vez que
    hayas registrado tu solicitud de prueba de manejo se en te enviará un recordatorio de tu pruba de manejo. ¡Espero que está información te 
    haya servido y pronto te veamos por aquí!",



 //Preguntas Frecuentes y Clave HU04 Y HU09
 
 "preguntas frecuentes" => "Ofrecemos información sobre: 'modelos', 'financiamiento', 'prueba de manejo', 'garantías', 'servicio postventa', 'horarios' y 'seguro'. ¿Sobre qué deseas saber?",
    
 "modelos" => "Actualmente contamos con los siguientes modelos en estado Semi Nuevo:\n- Toyota Prado TXL 2023\n- Toyota Rav4 2022\n- Toyota Fortuner 2020\n- Toyota Fortuner 2022\n- Toyota Prado VX 2016\n- Toyota Hilux 2019\n- Toyota Rush 2023\n- Toyota Corolla Cross 2023\n- Toyota Raize 2023\n- Suzuki Vitara 2023\n- Hyundai Tucson 2017",
 
 "financiamiento" => "Ofrecemos financiamiento a través de Banco Nacional, Banco Popular, CrediQ y nuestra Financiera propia (sujeta a estudio crediticio y con limitaciones de tiempo y monto). La aprobación depende de tu perfil crediticio.",
 
 "prueba de manejo" => "Para agendar una prueba de manejo, contacta con nuestro encargado. Las citas se realizan de lunes a viernes (8:00 am a 5:00 pm) y los sábados en casos especiales.",
 
 "garantias" => "Nuestros vehículos tienen garantía de 6 meses o 10,000 km, lo que ocurra primero. Consulta con nuestro servicio postventa para más detalles.",
 
 "servicio postventa" => "Contamos con un servicio postventa especializado para mantenimiento, reparaciones y revisiones. Nuestro equipo está listo para asistirte.",
 
 "horarios" => "Nuestro horario de atención es de lunes a viernes de 8:00 am a 6:00 pm y los sábados de 9:00 am a 1:00 pm.",
 
 "seguro" => "Ofrecemos opciones de seguro para tu vehículo. Consulta con nuestro asesor para conocer las coberturas y precios.",
 

    //Agradecimiento
    "muchas gracias"=>"¡Con mucho gusto, espero haberte ayudado!",
    
    
    
    
       
    //name
    "como te llamas?" =>"Soy MotorsBot y estoy para servirte",
    "cual es tu nombre?" =>"Soy MotorsBot y estoy para servirte",
    "tienes nombre?" =>"Soy MotorsBot y estoy para servirte",

    


    //saludo
    "hola" =>"Hola, como puedo ayudarte!",
 
    //despedida
    "adios" =>"nos vemos pronto",
    "hasta la proxima" =>"nos vemos pronto",
    
   


    "tu nombre es?" => "Mi nombre es " . $bot->getName(),
    
];

if (isset($_GET['msg'])) {
   
    $msg = strtolower($_GET['msg']);
    $bot->hears($msg, function (Bot $botty) {
        global $msg;
        global $questions;
        if ($msg == 'hi' || $msg == "hello") {
            $botty->reply('Hola');
        } elseif ($botty->ask($msg, $questions) == "") {
            $botty->reply("Lo siento, no poseo esa información pero puedes contactarte con nosotros por vía telefónica o mensajería directa");
        } else {
            $botty->reply($botty->ask($msg,$questions));
        }
    });
}
