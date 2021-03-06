<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="css/foundation.css">
  <script src="js/modernizr.js"></script>
  <title>P2P</title>

</head>
<body>
 <div class="row menufondo fondo">
    <div class="large-3 columns fondo2">
      <h1 class = "letra">Servidor</h1>
    </div>
    <div class="large-9 columns fondo2">
      <ul class="right button-group">
      <li><a href="index.php" class="button">Inicio</a></li>
      
         <?php 
        require_once('sesion.php');
        if ($estado) {   
      ?>
         <li><a href="compartir.php" class="button">Graficar</a></li>
         <li><a href="finsesion.php" class="button">Log-out</a></li>
     <?php
       
        }else{
       ?>
      <li><a href=""data-reveal-id="myModal" class="button">Login</a></li>
      <li><a href="registro.php" class="button">Registrate</a></li>
         <?php
        }
        ?>
      </ul>
     </div>
   </div>

    <div class="row">
    <div id="myModal"  class="reveal-modal large-centered" data-reveal >
        <form method="post" action="login.php">
            <h3>Login</h3>
            <input name="login" type="text" placeholder="Ingrese usuario"/>
            <input name="pass" type="password" placeholder="Ingrese contraseña"/>
            <button type="submit "  class="colorbutton">Iniciar Sesion</button>
        </form>
        <a class="close-reveal-modal">&#215;</a>
    </div>
  </div>
  
  <div class="row">
    <div class="panel color">
     <canvas id="graphCanvas" width="800" height="800"></canvas>
    <div class="Botones">
      Grafica puntos desde archivo <input id="graphFilePoints" type="file" size="50" onchange="graphFilePoints(this.files)" text="Graficar puntos desde el archivo"><br>
      <input id="graphFunctionSin" type="button" size="50" onclick="graphFunctionCanvas(1)" value="Seno simple"><br>
      <input id="graphFunctionCoseno" type="button" size="50" onclick="graphFunctionCanvas(2)" value="Coseno simple"><br>
      <input id="graphTaylorSin" type="button" size="50" onclick="graphTaylorCanvas(1)" value="Series Taylor Seno"><br>
      <input id="graphTaylorCos" type="button" size="50" onclick="graphTaylorCanvas(2)" value="Series Taylor Cos"><br>
        </div>
    <script>
    
     
        
        
      function Graph() {
        // asignacion de propiedades de los ejes para llevar un control de la escala
        this.canvas = document.getElementById("graphCanvas");
        this.minX = -8;
        this.minY = -8;
        this.maxX = 8;
        this.maxY = 8;
        this.graphUnits = 1;
        this.axisColor = '#aaa';
        this.font = '5pt Arial';
        this.axisTickSize = 20;

        // Le damos los parametros a propiedades del canvas
        this.context = this.canvas.getContext('2d');
        this.rangeX = this.maxX - this.minX;
        this.rangeY = this.maxY - this.minY;
        this.unitX = this.canvas.width / this.rangeX;
        this.unitY = this.canvas.height / this.rangeY;
        this.centerY = Math.round(Math.abs(this.minY / this.rangeY) * this.canvas.height);
        this.centerX = Math.round(Math.abs(this.minX / this.rangeX) * this.canvas.width);
        this.iteration = (this.maxX - this.minX) / 1000;
        this.scaleX = this.canvas.width / this.rangeX;
        this.scaleY = this.canvas.height / this.rangeY;
        this.setXAxis(); //establecemos los ejes con los parametros pasados
        this.setYAxis();
      }

      Graph.prototype.setXAxis = function() {// se dibuja eje x
        var context = this.context;
        context.save();
        context.beginPath();
        context.moveTo(0, this.centerY);
        context.lineTo(this.canvas.width, this.centerY);
        context.strokeStyle = this.axisColor;
        context.lineWidth = 2;
        context.stroke();


        var incrementX = this.graphUnits * this.unitX;
        var positionX, unit;
        context.font = this.font;
        context.textAlign = 'center';
        context.textBaseline = 'top';


        positionX = this.centerX - incrementX;
        unit = -1 * this.graphUnits;
        while(positionX > 0) {
          context.moveTo(positionX, this.centerY - this.axisTickSize / 2);
          context.lineTo(positionX, this.centerY + this.axisTickSize / 2);
          context.stroke();
          context.fillText(unit, positionX, this.centerY + this.axisTickSize / 2 + 3);
          unit -= this.graphUnits;
          positionX = Math.round(positionX - incrementX);
        }

        
        positionX = this.centerX + incrementX;
        unit = this.graphUnits;
        while(positionX < this.canvas.width) {
          context.moveTo(positionX, this.centerY - this.axisTickSize / 2);
          context.lineTo(positionX, this.centerY + this.axisTickSize / 2);
          context.stroke();
          context.fillText(unit, positionX, this.centerY + this.axisTickSize / 2 + 3);
          unit += this.graphUnits;
          positionX = Math.round(positionX + incrementX);
        }
        context.restore();
      };

      Graph.prototype.setYAxis = function() { //se dibuja eje y
        var context = this.context;
        context.save();
        context.beginPath();
        context.moveTo(this.centerX, 0);
        context.lineTo(this.centerX, this.canvas.height);
        context.strokeStyle = this.axisColor;
        context.lineWidth = 2;
        context.stroke();

        
        var incrementY = this.graphUnits * this.unitY;
        var positionY, unit;
        context.font = this.font;
        context.textAlign = 'right';
        context.textBaseline = 'middle';

    
        positionY = this.centerY - incrementY;
        unit = this.graphUnits;
        while(positionY > 0) {
          context.moveTo(this.centerX - this.axisTickSize / 2, positionY);
          context.lineTo(this.centerX + this.axisTickSize / 2, positionY);
          context.stroke();
          context.fillText(unit, this.centerX - this.axisTickSize / 2 - 3, positionY);
          unit += this.graphUnits;
          positionY = Math.round(positionY - incrementY);
        }

       
        positionY = this.centerY + incrementY;
        unit = -1 * this.graphUnits;
        while(positionY < this.canvas.height) {
          context.moveTo(this.centerX - this.axisTickSize / 2, positionY);
          context.lineTo(this.centerX + this.axisTickSize / 2, positionY);
          context.stroke();
          context.fillText(unit, this.centerX - this.axisTickSize / 2 - 3, positionY);
          unit -= this.graphUnits;
          positionY = Math.round(positionY + incrementY);
        }
        context.restore();
      };

        
        
        
        
      Graph.prototype.graphFunction = function(funcionX,color) { //importante- grafica  una funcion que envies de parametro con el color deseado, en este caso puede ser seno o coseno
        var context = this.context;
        context.save();
        context.save();
        this.centerContext();
          
        context.beginPath();
        context.moveTo(this.minX, funcionX(this.minX));
        console.log('funcion sencilla:   ');
          for(var x = this.minX + this.iteration; x <= this.maxX; x += this.iteration) { //se iteran los puntos
            context.lineTo(x, funcionX(x));
             console.log('X: '+ x +'Y: '+funcionX(x));
            }
        context.restore();
        context.lineJoin = 'round';
        context.lineWidth = 10;
        context.strokeStyle = color;
        context.stroke();
        context.restore();
      };
        
        
      Graph.prototype.centerContext = function() { //se centra la posicion y se le asigna la escala al context desde el inicio al fin
        var context = this.context;
        this.context.translate(this.centerX, this.centerY); 
        context.scale(this.scaleX, -this.scaleY);
      };
        
        
  Graph.prototype.drawPoints= function(x,y,color,lineWidth){ // la funcion se encarga de recibir arreglos de puntos x & y para empesar a  imprimir dentro del canvas segun las coordenadas y la escala del canvas con el color deseado
        var context = this.context;
        context.save();
        context.save();
        this.centerContext();    
        var lengthX= x.length;
        var lengthY= y.length;
        var t=lengthX;
        if(lengthX>lengthY)
          t=lengthY;
        var minValX=Math.min.apply(null, x);
        var minValY=Math.min.apply(null, y);
        var maxValX=Math.max.apply(null, x);
        var maxValY=Math.max.apply(null, y);
        if(Math.abs(maxValX)<Math.abs(minValX))
          maxValX=Math.abs(minValX);
        if(Math.abs(maxValY)<Math.abs(minValY))
          maxValY=Math.abs(minValY);
      
        var realX=0;
        var realY=0;
                console.log('funcion taylor o de arcchivos:   ');
        context.beginPath();
        context.moveTo(40*(x[0]/maxValX), 40*(y[0]/maxValY));
        for(var i=0;i<t;i++){
            
          realX=0;
          realY=0;
       
            if(x[i]>0)
               realX= this.maxX*(x[i]/maxValX);
            else
                realX= this.maxX*(x[i]/maxValX);
            if(y[i]>0)
                realY= this.maxY*(y[i]/maxValY); 
            else
                realY= this.maxY*(y[i]/maxValY);
            
            context.lineTo(realX, realY);
            console.log(realX+"," +realY);
            
      }
        context.restore();
        context.lineJoin = 'round';
        context.lineWidth = lineWidth;
        context.strokeStyle = color;
        context.stroke();
        context.restore();
}
  
  
  
  Graph.prototype.graphTaylor= function(tipo){ // en esta funcion se trata de cumplir las series de taylor llevando un numero de derivadas consecutivas de la funcion deseada
  var a=0;
    var setX=[];
  var setY=[];
  var val=0;

  fact = function(num){
    tot = 1;
    for (var i = 1; i <= num; i++) tot *= i;
    return tot;
    }

  for(var i=-2;i<2;i=i+0.01){
    setX[val]=i*Math.PI;
    val++;
  }
  if(tipo === 1 ){
  for(val--;val>=0;val--)
  setY[val]=Math.sin(setX[val])+((Math.cos(setX[val])/fact(1))*(setX[val]-a))+((-Math.sin(setX[val])/fact(2))*Math.pow(setX[val]-a,2))+((-Math.cos(setX[val])/fact(3))*Math.pow(setX[val]-a,3))+((Math.sin(setX[val])/fact(4))*Math.pow(setX[val]-a,4))+((Math.cos(setX[val])/fact(5))*Math.pow(setX[val]-a,5))+((-Math.sin(setX[val])/fact(6))*Math.pow(setX[val]-a,6))+((-Math.cos(setX[val])/fact(7))*Math.pow(setX[val]-a,7))+((Math.sin(setX[val])/fact(8))*Math.pow(setX[val]-a,8))+((Math.cos(setX[val])/fact(9))*Math.pow(setX[val]-a,9))+((-Math.sin(setX[val])/fact(10))*Math.pow(setX[val]-a,10))+((-Math.cos(setX[val])/fact(11))*Math.pow(setX[val]-a,11))+((Math.sin(setX[val])/fact(12))*Math.pow(setX[val]-a,12))+((Math.cos(setX[val])/fact(13))*Math.pow(setX[val]-a,13))+((-Math.sin(setX[val])/fact(14))*Math.pow(setX[val]-a,14))+((-Math.cos(setX[val])/fact(15))*Math.pow(setX[val]-a,15))+((Math.sin(setX[val])/fact(16))*Math.pow(setX[val]-a,16))+((Math.cos(setX[val])/fact(17))*Math.pow(setX[val]-a,17))+((-Math.sin(setX[val])/fact(18))*Math.pow(setX[val]-a,18))+((-Math.cos(setX[val])/fact(19))*Math.pow(setX[val]-a,19));
    this.drawPoints(setX,setY,'blue');
    }
    if(tipo === 2 ){
    for(val--;val>=0;val--)
    setY[val]=Math.cos(setX[val])+((-Math.sin(setX[val])/fact(1))*(setX[val]-a))+((-Math.cos(setX[val])/fact(2))*Math.pow(setX[val]-a,2))+((Math.sin(setX[val])/fact(3))*Math.pow(setX[val]-a,3))+((Math.cos(setX[val])/fact(4))*Math.pow(setX[val]-a,4))+((-Math.sin(setX[val])/fact(5))*Math.pow(setX[val]-a,5))+((-Math.cos(setX[val])/fact(6))*Math.pow(setX[val]-a,6))+((Math.sin(setX[val])/fact(7))*Math.pow(setX[val]-a,7))+((Math.cos(setX[val])/fact(8))*Math.pow(setX[val]-a,8))+((-Math.sin(setX[val])/fact(9))*Math.pow(setX[val]-a,9))+((-Math.cos(setX[val])/fact(10))*Math.pow(setX[val]-a,10))+((Math.sin(setX[val])/fact(11))*Math.pow(setX[val]-a,11))+((Math.cos(setX[val])/fact(12))*Math.pow(setX[val]-a,12))+((-Math.sin(setX[val])/fact(13))*Math.pow(setX[val]-a,13))+((-Math.cos(setX[val])/fact(14))*Math.pow(setX[val]-a,14))+((Math.sin(setX[val])/fact(15))*Math.pow(setX[val]-a,15))+((Math.cos(setX[val])/fact(16))*Math.pow(setX[val]-a,16))+((-Math.sin(setX[val])/fact(17))*Math.pow(setX[val]-a,17))+((-Math.cos(setX[val])/fact(18))*Math.pow(setX[val]-a,18))+((Math.sin(setX[val])/fact(19))*Math.pow(setX[val]-a,19));  
    
    this.drawPoints(setX,setY,'yellow');
  
  }    
}


Graph.prototype.sortPoints= function(data){
var col=[];
var miny=0;
var index=0;
    data.splice(150,data.length);

for(var i=0;i<150;i++){
     miny=Math.min.apply(null, data);
     index=data.indexOf(miny);
     console.log(index);
     col[i]=index;
     data[index]=1000000000000;
}
return col;
}

Graph.prototype.changeVal= function(data){
var col=[];
for(var i=0;i<data.length;i++)
col[i]=data[i]*1;
return col;
}

Graph.prototype.sortVal= function(index,data){
var col=[];
for(var i=0;i<150;i++){
    col[i]=data[index[i]];
}
return col;
}
  
  // aqui van las funciones fuera del objeto graph,se trata de los botones
  
        
    
        
      

      function  graphFilePoints(files){ //se lee el archivo, se separan los puntos que se dan, y se mandan a graficar y se acompleta mediante la grange
          var file = files[0];
          var reader = new FileReader();
          alert("color rojo= original, color azul=puntos enlazados que se encontraron con LaGrange");
        reader.onload = function (e) {

                    var myGraph = new Graph();
                    var archivo=e.target.result;
                    archivo=archivo.replace(' ','');
                    var dat=archivo.split('=[');
                    dat[1]=dat[1].replace("t","");
                    dat[1]=dat[1].replace("]","");
                    dat[2]=dat[2].replace("]","");
                    dat[2]=dat[2].replace("ultimos 50","");
                    dat[3]=dat[3].replace("]","");
                    dat[3]=dat[3].replace("]","");
                    var x= dat[1].split(',');
        var y= dat[2].split(',');
        myGraph.drawPoints(x,y,'red',7);
        var index=[];
        var convertidos=myGraph.changeVal(y);
        index=myGraph.sortPoints(convertidos);
        x=myGraph.sortVal(index,x);
        y=myGraph.sortVal(index,y);
        var pointsToFind= dat[3].split(',');
        pointsToFind=myGraph.changeVal(pointsToFind);
        var nx= x.length;
        var ny= y.length;
        var t=nx;
        if(nx>ny)t=ny;
        var npointsToFind=pointsToFind.length;
        var dividendVal=[];
        var divisorVal=[];
        var divisorFin=[];
        var minx=Math.min.apply(null, x);
        var maxx=Math.max.apply(null, x);
        //Obtener Divisor
        for(var i=0;i<t;i++){

          var res=1;
          for(var z=0;z<t;z++){
            if(i!=z)
              res*=(y[i]-y[z]);
          }
          divisorFin[i]=res;
        }

        var d=0;
        var dividendFin;
        var xm=[];
        var ym=[];
        for(var n=nx;n<(nx+npointsToFind);n++){
          dividendVal=[];
            divisorVal=[];
          dividendFin=0;
          var resY=0;
        //Obtener todos los dividendVals
          for(var z=0;z<t;z++){
            dividendVal[z]=(pointsToFind[d]-y[z]);
          }
        //Obtener Divisor
        var div=[];
          for(var w=0;w<t;w++){
            dividendFin=1;
            for(var z=0;z<t;z++){
            if(w!=z)
              dividendFin*=dividendVal[z];
            }

            div[w]=dividendFin;
          }
        //Obtener Resultado de Y
          for(var z=0;z<t;z++){
            resY+=(x[z]*(div[z]/divisorFin[z]));
          }
          
          if(resY<(maxx+1)&&resY>(minx)-1){
            x[150+d]=resY;
            y[150+d]=pointsToFind[d];
          }
          else{ 
                y[150+d]=pointsToFind[d];
                var p1=0;
                var p2=0;
                while(y[p2]<pointsToFind[d] && p2<150)
                    p2++;
                p1=p2-1;
                if(p2==150){
                    p1=p2-2;
                    p2=p2-1;
                }
                if(p1==-1){
                    p1=0;
                    p2=1;
                }
                x[150+d]=(x[p1]*1)+(((x[p2]-x[p1])*(pointsToFind[d]-y[p1]))/(y[p2]-y[p1]));
          }

          d++;
      }
                    myGraph.drawPoints(x,y,'blue',3);
                                 
                    
                    };    
            reader.readAsText(file); 
      }
        
        
        
    function  graphTaylorCanvas(tipo){//se  grafica mediante series de taylor sin y coseno segun el valor
      var myGraph = new Graph();
      myGraph.graphTaylor(tipo,2);
      }
        
    function  graphFunctionCanvas(tipo){ // se obtiene el valor de la funcion a desplegar sin es 1 y cos es 2
      var myGraph = new Graph();
      if(tipo === 1){
      myGraph.graphFunction(function(x) {
              return  8* Math.sin(x*.5*Math.PI);  //puede ser de 1 a 20 el valor - se establece como se va a iterar la funcion para graficar puntos
                },'red');
              }
       if(tipo === 2){
      myGraph.graphFunction(function(x) {
              return  8* Math.cos(x*.5*Math.PI);  //puede ser de 1 a 20 el valor - se establece como se va a iterar la funcion para graficar puntos
                },'black');
              }

      }
        

    </script>
  </div>
  </div>



<div class="row">
    <div class="large-12 columns">
    
      <div class="panel color">
        <h4>Sugerencias</h4>
            
        <div class="row">
          <div class="large-9 columns">
            <p>Nos gustaria mucho escuchar tu opinion</p>
          </div>
          <div class="large-3 columns">
            <a href="#" class="radius button right contacto">Contactanos</a>
          </div>
        </div>
      </div>
      
    </div>
  </div>

   <footer class="row">
    <div class="large-12 columns">
      <hr/>
      <div class="row">
        <div class="large-6 columns">
          <p>Bilioteca</p>
        </div>
        <div class="large-6 columns">
          <ul class="inline-list right">
            <li><a href="index.html">Inicio</a></li>
            <li><a href="libros.php">Archivos</a></li>
            <?php 
            if ($estado) {
             ?>
            <li><a href="finsesion.php">Close</a></li>
            <?php 
            }else{
             ?>
            <li><a href="#"data-reveal-id="myModal">Login</a></li>
            <li><a href="registro.php">Registrate</a></li>
            <?php 
          }
             ?>
          </ul>
        </div>
      </div>
    </div> 
  </footer>

  
</body>
<script src="js/vendor/jquery.js"></script>
<script src="js/foundation.min.js"></script>
<script>
  $(document).foundation();
</script>
</html>