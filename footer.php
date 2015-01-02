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
      
		 <?php dynamic_sidebar('footer'); ?>
      
    
        <div class="pull-right">        
            <a id="gototop" class="gototop" href="#"><i class="fa fa-chevron-up"></i></a><!--#gototop-->         
        </div>
      
    </div>
  </div>
</footer><!--/#footer-->

<?php //google_analytics();?>

<?php wp_footer(); ?>

</body>
</html>