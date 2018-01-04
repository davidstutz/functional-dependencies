<!DOCTYPE html>
<html>
    <head>
        <title><?php echo __('PHP Functional Dpendencies - Credits'); ?></title>
        <meta name="description" content="Algorithms for functional dependencies from relational database theory implemented in PHP.">
        <meta name="keyword" content="relational database theory,relational database,functional dependencies,dependency,php functional dependencies,php">

        <script type="text/javascript" src="/<?php echo $app->config('base'); ?>/Assets/Js/jquery.min.js"></script>
        <script type="text/javascript" src="/<?php echo $app->config('base'); ?>/Assets/Js/bootstrap.min.js"></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.2/MathJax.js?config=TeX-MML-AM_CHTML'></script>
        <script type="text/x-mathjax-config">
            MathJax.Hub.Config({
            tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('body').css('display', 'none');
                $('body').fadeIn(800);
                
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
                    <div  style="padding:11px 19px;">
                        &copy; 2013 <a href="http://davidstutz.de">David Stutz</a><br>
                        <a href="http://davidstutz.de/impressum-legal-notice/"><?php echo __('Impressum - Legal Notice'); ?></a>
                    </div>
                </div>
                <div class="span10">
                    <div class="page-header">
                        <h1><?php echo __('Functional Dependencies'); ?></h1>
                    </div>
                    
                    <ul class="nav nav-pills">
                        <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('theory'); ?>" class="transition"><?php echo __('Theory'); ?></a></li>
                        <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('demo'); ?>" class="transition"><?php echo __('Demo'); ?></a></li>
                        <li class="active"><a href="#"><?php echo __('Credits'); ?></a></li>
                    </ul>
                </div>
            </div>
            
            <div class="row">
                <div class="span2 tile"></div>
                <div class="span10">
                    <p>
                        <b><?php echo __('About me.'); ?></b> <?php echo __('Visit my personal website:'); ?> <a href="http://davidstutz.de" target="_blank">davidstutz.de</a>.
                    </p>
                    
                    <p>
                        <b><?php echo __('Code.'); ?></b> <?php echo __('Visit the project on GitHub:'); ?> <a href="https://github.com/davidstutz/functional-dependencies" target="_blank">davidstutz/functional-dependencies</a>
                    </p>
                    
                    <p><b><?php echo __('Sources.'); ?></b></p>
                    
                    <p>
                        <ul>
                            <li><a href="http://en.wikipedia.org/wiki/Relation_schema" target="_blank"><?php echo __('Wikipedia: Relation (database)'); ?></a> <span class="muted"><?php echo __(' - visited june 2013'); ?></span></li>
                            <li><a href="http://en.wikipedia.org/wiki/Functional_dependency" target="_blank"><?php echo __('Wikipedia: Functional Dependency'); ?></a> <span class="muted"><?php echo __(' - visited june 2013'); ?></span></li>
                            <li><a href="http://en.wikipedia.org/wiki/Superkey" target="_blank"><?php echo __('Wikipedia: Superkey'); ?></a> <span class="muted"><?php echo __(' - visited june 2013'); ?></span></li>
                            <li><a href="http://en.wikipedia.org/wiki/Candidate_key" target="_blank"><?php echo __('Wikipedia: Candidate Key'); ?></a> <span class="muted"><?php echo __(' - visited june 2013'); ?></span></li>
                            <li><a href="http://csc.lsu.edu/~jianhua/fd_slide2_09.pdf" target="_blank"><?php echo __('Candidate Keys'); ?></a> <span class="muted"><?php echo __(' - visited june 2013'); ?></span></li>
                            <li><?php echo __('Datenbanksysteme: Eine Einf&uuml;hrung, A. Kemper, A. Eickler, 7. Auflage, Oldenbourg Verlag'); ?></li>
                            <li><a href="http://en.wikipedia.org/wiki/Power_set" target="_blank"><?php echo __('Wikipedia: Power Set'); ?></a> <span class="muted"><?php echo __(' - visited june 2013'); ?></span></li>
                        </ul>
                    </p>
                    
                    <p><b><?php echo __('Built with.'); ?></b></p>
                    
                    <p>
                        <ul>
                            <li><a href="http://twitter.github.com/bootstrap/" target="_blank"><?php echo __('Twitter Bootstrap'); ?></a></li>
                            <li><a href="http://www.mathjax.org/" target="_blank"><?php echo __('MathJax'); ?></a></li>
                            <li><a href="http://www.slimframework.com/" target="_blank"><?php echo __('Slim'); ?></a></li>
                        </ul>
                    </p>
                    
                    <p>
                        <b><?php echo __('License.'); ?></b> <?php echo __('The source of this demonstration application is published under the GNU General Public License Version 3.'); ?>
                    </p>
                    
                    <pre>
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see http://www.gnu.org/licenses/.
                    </pre>
                    
                    <p>
                        <?php echo __('In addition the discussed content is provided without any warranty!'); ?>
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>