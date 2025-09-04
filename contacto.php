<!DOCTYPE html>
<html lang="es">

<?php include("encabezado.php");
include_once ("funciones.php");?>
<title>TuTorahKids.tv</title>

<body>
  <?php include("menu.php"); ?>


  <div class="container" id="info" style="padding-top:5.5rem;">

    <div class="row justify-content-center">

      <div class="col-12 text-center my-5">
        <h3>Si tienes alguna duda, comentario o quieres participar<br>en alguno de nuestros programas, contáctanos.</h3>
      </div>

      <div class="col-12 col-lg-4 px-5">
        <a href="#" class="btn btn-lg btn-secondary btn-block mb-3 mb-lg-0 fw6" id="correo"><span class="fa fa-envelope"></span> Contacto</a>
      </div>

      <div class="col-12 col-lg-4 px-5">
        <a class="btn btn-lg btn-success btn-block mb-3 mb-lg-0 fw6" id="whatsapp" href="https://api.whatsapp.com/send?phone=525573735843&text=Hola!" target="_blank"><img style="vertical-align: sub;" src="images/whatsapp-brands.svg" width="18" alt=""> Whatsapp
        </a>
      </div>

    </div>

    <div class="row justify-content-center">

      <div class="col-12 col-lg-8" id="resultado1" style="display:none;">
        <form name="" method="post" id="sendemail" name="sendemail" style="padding:20px 30px;">
          <div class="form-group">
            <label class="small ml-2 mb-1 mt-2">Nombre (requerido)</label>
            <input type="text" class="form-control" name="nombre" id="formGroupExampleInput" placeholder="" style="width:100%;" required>
          </div>
          <div class="form-group">
            <label class="small ml-2 mb-1 mt-2">Correo electrónico (requerido)</label>
            <input type="email" class="form-control" name="correo" id="formGroupExampleInput" placeholder="" required>
          </div>
          <div class="form-group">
            <label class="small ml-2 mb-1 mt-2">Asunto</label>
            <input type="text" class="form-control" name="asunto" placeholder="" required>
          </div>
          <div class="form-group">
            <label class="small ml-2 mb-1 mt-2">Mensaje</label>
            <span class="wpcf7-form-control-wrap your-message bordin"><textarea name="mensaje" cols="40" rows="10" class="form-control" required></textarea></span>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-lg btn-purple text-white btn-block" id="sendemail1" name="sendemail1">
              <i class="fa fa-paper-plane"></i> Enviar Mensaje
            </button>
          </div>
        </form>
      </div>
      <div class="col-12 text-center">
        <div id="resultado_send"></div>
      </div>

    </div>

    <div class="row">
      <div class="lead text-center" id="resultado2" style="display:none;">
        <font style="display:none;" color="black">+52 55 7373 5843</font>
      </div>
    </div>

  </div>
  <!-- /.container -->
  <!-- Bootstrap core JavaScript
    ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

  <script type="text/javascript">
    $(document).ready(function() {

      $('#correo').click(function() {
        if ($('#resultado1').is(':visible')) {
          $('#resultado1').hide();
        } else {
          $('#resultado2').hide();
          $("#resultado1").slideToggle(1000);
          $('#resultado1').show();
          //$('#resultado1').load('contacto_res.php?v=1');
        }
      });

      $('#whatsapp').click(function() {
        if ($('#resultado2').is(':visible')) {
          $('#resultado2').hide();
        } else {
          $('#resultado1').hide();
          $("#resultado2").slideToggle(1000);
          $('#resultado2').show();
          //$('#resultado2').load('contacto_res.php?v=2');
        }
      });

      $('#sendemail').submit(function() {
        event.preventDefault();
        $.ajax({
          type: 'POST',
          url: 'contacto_res.php?v=3',
          data: $('#sendemail').serialize(), // Adjuntar los campos del formulario enviado.
          success: function(data) {
            $('#resultado_send').html(data); // Mostrar la respuestas del script PHP.
            setTimeout(function() {
              $('#resultado1').hide(1000);
              $('#resultado_send').html("");
            }, 5000);
          }
        });
      });

    });

  </script>


</body>

</html>
