<?php

include("header.php");
include("slider_principal.php");

//Poner abajito algo que diga registrarte y abra el modal 
//include("ponentes.php");
//include("calendario_eventos.php");

//include("galeria_home.php");
include("footer.php");

?>

    <script>
        
   $(function(){

        $('a[href*=quienes_somos]').click(function() {

         if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')
             && location.hostname == this.hostname) {

                 var $target = $(this.hash);

                 $target = $target.length && $target || $('[name=' + this.hash.slice(1) +']');

                 if ($target.length) {

                     var targetOffset = $target.offset().top;

                     $('html,body').animate({scrollTop: targetOffset}, 1000);

                     return false;

                }

           }

});
       
        $('a[href*=servicios_home]').click(function() {

         if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')
             && location.hostname == this.hostname) {

                 var $target = $(this.hash);

                 $target = $target.length && $target || $('[name=' + this.hash.slice(1) +']');

                 if ($target.length) {

                     var targetOffset = $target.offset().top;

                     $('html,body').animate({scrollTop: targetOffset}, 1000);

                     return false;

                }

           }

       });      

        $('a[href*=galeria_home]').click(function() {

         if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')
             && location.hostname == this.hostname) {

                 var $target = $(this.hash);

                 $target = $target.length && $target || $('[name=' + this.hash.slice(1) +']');

                 if ($target.length) {

                     var targetOffset = $target.offset().top;

                     $('html,body').animate({scrollTop: targetOffset}, 1000);

                     return false;

                }

           }

       });          
                 
        $('a[href*=ubicacion]').click(function() {

     if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')
         && location.hostname == this.hostname) {

             var $target = $(this.hash);

             $target = $target.length && $target || $('[name=' + this.hash.slice(1) +']');

             if ($target.length) {

                 var targetOffset = $target.offset().top;

                 $('html,body').animate({scrollTop: targetOffset}, 1000);

                 return false;

            }

       }

   });
            
            
        
            

});
     
        
        
    </script>