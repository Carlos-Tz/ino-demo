var udateTime = function() {
    let currentDate = new Date(),
        hours = currentDate.getHours(),
        minutes = currentDate.getMinutes(), 
        seconds = currentDate.getSeconds(),
        weekDay = currentDate.getDay(), 
        day = currentDate.getDate(), 
        month = currentDate.getMonth(), 
        year = currentDate.getFullYear();
        
    const weekDays = [
        'Domingo',
        'Lunes',
        'Martes',
        'Miércoles',
        'Jueves',
        'Viernes',
        'Sabado'
    ];
 
    document.getElementById('weekDay').textContent = weekDays[weekDay];
    document.getElementById('day').textContent = day;
 
    const months = [
        'Enero',
        'Febrero',
        'Marzo',
        'Abril',
        'Mayo',
        'Junio',
        'Julio',
        'Agosto',
        'Septiembre',
        'Octubre',
        'Noviembre',
        'Diciembre'
    ];
 
    document.getElementById('month').textContent = months[month];
    document.getElementById('year').textContent = year;
 
    document.getElementById('hours').textContent = hours;
 
    if (minutes < 10) {
        minutes = "0" + minutes
    }
 
    if (seconds < 10) {
        seconds = "0" + seconds
    }
 
    document.getElementById('minutes').textContent = minutes;
    document.getElementById('seconds').textContent = seconds;
};

function semanadelanio(){
    var f = new Date();
    var $fecha = f.getDate() + "/" + (f.getMonth() +1) + "/" + f.getFullYear();
    $const  =  [2,1,7,6,5,4,3]; 
    // Constantes para el calculo del primer dia de la primera semana del año
     
    if ($fecha.match(/\//)){
      $fecha   =  $fecha.replace(/\//g,"-",$fecha);
    };
    // Con lo anterior permitimos que la fecha pasada a la funcion este
    // separada por "/" al remplazarlas por "-" mediante .replace y el uso
    // de expresiones regulares
        
    $fecha  =  $fecha.split("-");
    // Partimos la fecha en trozos para obtener dia, mes y año por separado
    $dia    =  eval($fecha[0]);
    $mes    =  eval($fecha[1]);
    $anio       =  eval($fecha[2]);   
    if ($mes!=0) {
      $mes--;
    };
    // Convertimos el mes a formato javascript 0=enero
    
    $dia_pri   =  new Date($anio,0,1); 
    $dia_pri   =  $dia_pri.getDay();
    // Obtenemos el dia de la semana del 1 de enero
    $dia_pri   =  eval($const[$dia_pri]);
    // Obtenemos el valor de la constante correspondiente al día
    $tiempo0   =  new Date($anio,0,$dia_pri);
    // Establecemos la fecha del primer dia de la semana del año
    $dia       =  ($dia+$dia_pri);
    // Sumamos el valor de la constante a la fecha ingresada para mantener 
    // los lapsos de tiempo
    $tiempo1   =  new Date($anio,$mes,$dia);
    // Obtenemos la fecha con la que operaremos
    $lapso     =  ($tiempo1 - $tiempo0)
    // Restamos ambas fechas y obtenemos una marca de tiempo
    $semanas   =  Math.floor($lapso/1000/60/60/24/7);
    // Dividimos la marca de tiempo para obtener el numero de semanas
     
    if ($dia_pri == 1) {
      $semanas++;
    };
    // Si el 1 de enero es lunes le sumamos 1 a la semana caso contrarios el
    // calculo nos daria 0 y nos presentaria la semana como semana 52 del 
    // año anterior
     
    if ($semanas == 0) {
      $semanas=52;
      $anio--;
    };
    // Establecemos que si el resultado de semanas es 0 lo cambie a 52 y 
    // reste 1 al año esto funciona para todos los años en donde el 1 de 
    // Enero no es Lunes
     
    if ($anio < 10) {
      $anio = '0'+$anio;
    };
    // Por pura estetica establecemos que si el año es menor de 10, aumente 
    // un 0 por delante, esto para aquellos que ingresen formato de fecha
    // corto dd/mm/yy
     
   // console.log($semanas+" - "+$anio);
    // Con esta sentencia arrojamos el resultado. Esta ultima linea puede ser
    // cambiada a gusto y conveniencia del lector 
}; 
udateTime();
setInterval(udateTime, 1000);