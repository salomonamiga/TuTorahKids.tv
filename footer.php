<footer class="container-fluid bg-light">
    <div class="container">
      <div id="footer-child" class="row justify-content-center justify-content-lg-between py-4 py-md-3 mt-5 text-center">
        <div class="col-auto text-blue">© Copyright Tutorah.Tv 2019</div>
        <div class="col-auto text-blue"><a href="#">Términos y condiciones Aviso de privacidad</a></div>
      </div>
    </div>
  </footer>
  <!-- /.container -->
  <!-- Bootstrap core JavaScript
    ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  
 
 <script>
$(document).ready(function(){
  $(".navbar-toggler.fix").click(function(){
    $("body").toggleClass("ov");
    $("html").toggleClass("ov2");
  });
  
  ////close click anywhere
  
  /** CLOSE MAIN NAVIGATION WHEN CLICKING OUTSIDE THE MAIN NAVIGATION AREA**/
$(document).on('click', function (e){
    /* bootstrap collapse js adds "show" class in bs4 to your collapsible element*/
    var menu_opened = $('#main-navigation').hasClass('show');
  
    if(!$(e.target).closest('#main-navigation').length &&
        !$(e.target).is('#main-navigation') &&
        menu_opened === true){
            $('#main-navigation').collapse('toggle');
            $("body").toggleClass("ov");
            $("html").toggleClass("ov2");
    }

});
  
});
</script>