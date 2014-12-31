<?php if(!is_page()) { ?>
</div><!--/#primary-->
</div><!--/.col-lg-12-->
</div><!--/.row-->
</div><!--/.container.-->
</section><!--/#main-->
<?php } ?>

<section id="bottom">
  <div class="container">
    <div class="row">
      <?php dynamic_sidebar('bottom'); ?>
    </div>
  </div>
</section>

<footer id="footer">
  <div class="container">
    <div class="row">
      <div class="col-sm-6">
       
      </div>
      <div class="col-sm-6">
        <ul class="pull-right">
         
          <li>
            <a id="gototop" class="gototop" href="#"><i class="icon-chevron-up"></i></a><!--#gototop-->
          </li>
        </ul>
      </div>
    </div>
  </div>
</footer><!--/#footer-->

<?php //google_analytics();?>

<?php wp_footer(); ?>

</body>
</html>