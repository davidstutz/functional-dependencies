<!DOCTYPE html>
<html>
    <head>
        <title><?php echo __('Functional Dpendencies - Theory'); ?></title>
        <script type="text/javascript" src="/<?php echo $app->config('base'); ?>/Assets/Js/jquery.min.js"></script>
        <script type="text/javascript" src="/<?php echo $app->config('base'); ?>/Assets/Js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://c328740.ssl.cf1.rackcdn.com/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
        <script type="text/x-mathjax-config">
            MathJax.Hub.Config({
                tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('body').css('display', 'none');
                $('body').fadeIn(1500);
                
                $('a.transition').on('click', function(event) {
                   event.preventDefault();
                   linkLocation = this.href;
                   
                   $('body').fadeOut(1000, function() {
                       window.location = linkLocation;
                   });
                });
                
                $('.row').each(function() {
                    var height = 0;
                    $('> div[class^="span"]', this).each(function() {
                        if ($(this).height() > height) {
                            height = $(this).height();
                        }
                    });
                    
                    $('> div[class^="span"]', this).height(height);
                });
            });
        </script>
        <link rel="stylesheet" type="text/css" href="/<?php echo $app->config('base'); ?>/Assets/Css/bootstrap.css">
    </head>
    <body>
        <a href="https://github.com/davidstutz/functional-dependencies"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://s3.amazonaws.com/github/ribbons/forkme_right_red_aa0000.png" alt="Fork me on GitHub"></a>
        <div class="container">
            <div class="row">
                <div class="span2">
                    <div style="padding:11px 19px;">
                        &copy; 2013 <a href="http://davidstutz.de">David Stutz</a><br>
                        <a href="http://davidstutz.de/impressum-legal-notice/"><?php echo __('Impressum - Legal Notice'); ?></a>
                    </div>
                </div>
                <div class="span10">
                    <div class="page-header">
                        <h1><?php echo __('Functional Dependencies'); ?></h1>
                    </div>
                    
                    <ul class="nav nav-pills">
                        <li class="active"><a href="#"><?php echo __('Theory'); ?></a></li>
                        <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('demo'); ?>" class="transition"><?php echo __('Demo'); ?></a></li>
                        <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('credits'); ?>" class="transition"><?php echo __('Credits'); ?></a></li>
                    </ul>
                </div>
            </div>
            
            <div class="row">
                <div class="span2 tile"></div>
                <div class="span10">
                   <p>
                       <b><?php echo __('Definition.'); ?></b> <?php echo __('Given $n$ data domains $D_1, \ldots, D_n$. Then a relation is a subset of the cartesian product of the data domains: $R \subseteq D_1 \times \ldots \times D_n$.'); ?>
                   </p>
                   
                   <p>
                       <b><?php echo __('Remark.'); ?></b> <?php echo __('The data domains must not necessarily be distinct. Examples for valid data domains are numbers, strings etc., whereas sets or lists are not valid, because we will only allow data domains with atomar values.'); ?>
                   </p>
                   
                   <p>
                       <?php echo __('So a relation is a set of tuples. The data domains are usually given names and the different data domains used within a relation are referred to as attributes.'); ?>
                   </p>
                   
                   <p>
                       <b><?php echo __('Definition.'); ?></b> <?php echo __('A relation schema $\mathcal{R}$is a set of attributes also referred to as a table schema.'); ?>
                   </p>
                   
                   <p>
                       <?php echo __('Using these definitions a relation can be seen as an instance of a relation schema. For the following discussion of functional dependencies let $\mathcal{R}$ be a relation schema with instance $R$.'); ?>
                   </p>
                   
                   <p>
                       <b><?php echo __('Definition.'); ?></b> <?php echo __('Given sets $X, Y \subseteq \mathcal{R}$ of attributes. A functional dependency $X \rightarrow Y$ describes condition to the possible instances of the relation schema $\mathcal{R}$.'); ?>
                   </p>
                </div>
            </div>
        </div>
    </body>
</html>