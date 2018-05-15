<!DOCTYPE html>
<html>
    <head>
        <title><?php echo __('PHP Functional Dpendencies - Demo'); ?></title>
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
                    <div style="padding:11px 19px;">
                        &copy; 2013 - 2018<br>
						<a href="http://davidstutz.de">David Stutz</a><br>
                        <a href="https://davidstutz.de/impressum/">Impressum</a><br>
						<a href="https://davidstutz.de/datenschutz/">Datenschutz</a>
                    </div>
                </div>
                <div class="span10">
                    <div class="page-header">
                        <h1><?php echo __('Functional Dependencies'); ?></h1>
                    </div>
                    
                    <ul class="nav nav-pills">
                        <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('theory'); ?>" class="transition"><?php echo __('Theory'); ?></a></li>
                        <li class="active"><a href="#"><?php echo __('Demo'); ?></a></li>
                        <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('credits'); ?>" class="transition"><?php echo __('Credits'); ?></a></li>
                    </ul>
                </div>
            </div>
            
            <div class="row">
                <div class="span2 tile"></div>
                <div class="span10">
                    <?php if (isset($schema)): ?>
                        <pre style="margin-bottom:19px;">
<?php echo __('Attributes:'); ?> <?php echo $schema->getAttributes(); ?> 
<?php echo __('Functional Dependencies:'); ?> 
<?php foreach ($schema->getFunctionalDependencies()->asArray() as $dependency): ?>
<?php echo $dependency; ?> 
<?php endforeach; ?>
<?php echo __('Closures:'); ?> 
<?php foreach ($schema->getAttributes()->asArray() as $attribute): ?>
<?php echo $attribute . ':'; ?> <?php echo $schema->closure(new \Libraries\Set(array($attribute))); ?> 
<?php endforeach; ?>
<?php echo __('Super Keys:'); ?> <?php echo $schema->superKeys(); ?> 
<?php echo __('Candidate Keys:'); ?> <?php echo $schema->candidateKeys(); ?> 
<?php echo __('In 2NF:'); ?> <?php var_dump($schema->secondNormalForm()); ?>
<?php echo __('In 3NF:'); ?> <?php var_dump($schema->thirdNormalForm()); ?>
                        </pre>
                    <?php else: ?>
                        <p class="alert alert-info">
                            <?php echo __('Enter the attributes and function dependencies separated by <code>;</code>. Functional dependencies have to be of the form <code>A->A,B</code>. Note that an Attribute A is always functional depending on itself.'); ?>
                        </p>
                    <?php endif; ?>
                    <form class="form-horizontal" method="POST" action="/<?php echo $app->config('base') . $app->router()->urlFor('demo'); ?>">
                        <div class="control-group">
                            <label class="control-label"><?php echo __('Attributes'); ?></label>
                            <div class="controls">
                                <input type="text" name="attributes" class="span6" value="<?php echo $app->request()->post('attributes'); ?>" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><?php echo __('Functional Dependencies'); ?></label>
                            <div class="controls">
                                <input type="text" name="dependencies" class="span6" value="<?php echo $app->request()->post('dependencies'); ?>" />
                            </div>
                        </div>
                        <div class="form-actions">
                            <button class="btn btn-primary" type="submit"><?php echo __('Get Candidate Keys'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>