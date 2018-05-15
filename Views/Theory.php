<!DOCTYPE html>
<html>
    <head>
        <title><?php echo __('PHP Functional Dpendencies - Theory'); ?></title>
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
                        <?php echo __('This section is intended to provide the language and background to understand the algorithms used in the demo section.'); ?>
                    </p>
                    
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
                        <b><?php echo __('Definition.'); ?></b> <?php echo __('A relation schema $\mathcal{R}$ is a set of attributes also referred to as a table schema.'); ?>
                    </p>
                   
                    <p>
                        <?php echo __('Using these definitions a relation can be seen as an instance of a relation schema. For the following discussion of functional dependencies let $\mathcal{R}$ be a relation schema with instance $R$.'); ?>
                    </p>
                   
                    <p>
                        <?php echo __('For a tuple $r \in R$ and an attribute $A \in \mathcal{R}$ with $r[A]$ we denote the value of $r$ for the attribute $A$.'); ?>
                    </p>
                   
                    <p>
                        <b><?php echo __('Definition.'); ?></b> <?php echo __('Given sets $X, Y \subseteq \mathcal{R}$ of attributes. A functional dependency $X \rightarrow Y$ describes a condition to the possible instances of the relation schema $\mathcal{R}$: For all pairs of tuples $r,s \in R$ with $r[A] = t[A] \forall A \in X$ it must hold $r[B] = s[B] \forall B \in Y$.'); ?>
                    </p>
                   
                    <p>
                        <?php echo __('For the functional dependency $X \rightarrow Y$ the attribute set $X$ is said to functionally determine $Y$.'); ?>
                    </p>
                   
                    <p>
                        <?php echo __('Given a set $X \subseteq \mathcal{R}$ of attributes it is of interest to get the closure of $X$. The closure of $X$ denoted by $closure(X)$ is the set of attributes $X^+ \subseteq \mathcal{R}$ where every attribute $A \in X^+$ is functionally determined by $X$. For calculating $closure(X)$ the following algorithm can be used:'); ?>
                    </p>
                   
                     <p>
                        <b><?php echo __('Algorithm.'); ?></b>
                        <ul style="list-style-type:none;">
                            <li><?php echo __('$X^+ := X$;'); ?></li>
                            <li><?php echo __('while $X^+$ changes:'); ?>
                                <ul style="list-style-type:none;">
                                    <li><?php echo __('foreach functional dependency $Y \rightarrow Z$:'); ?>
                                        <ul style="list-style-type:none;">
                                            <?php echo __('if $Y \subseteq X^+$: $X^+ := X^+ \cup Z$'); ?>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </p>
                    
                    <p>
                        <?php echo __('Now that we know how to determine the closure of a set of attributes we can discuss superkeys and candidate keys.'); ?>
                    </p>
                    
                    <p>
                        <b><?php echo __('Definition.'); ?></b> <?php echo __('A super key $K \subseteq \mathcal{R}$ is a set of attributes such that every attribute $A \in \mathcal{R}$ is functional dependant on $K$, or in other words $A \in closure(K) \forall A\in \mathcal{R}$.'); ?>
                    </p>
                    
                    <p>
                        <?php echo __('Given the definition we already see a simple algorithm to determine all superkeys:'); ?>
                    </p>
                    
                    <p>
                        <b><?php echo __('Algorithm.'); ?></b>
                        <ul style="list-style-type:none;">
                            <li><?php echo __('foreach $X \in \mathcal{P}(\mathcal{R})$:'); ?>
                                <ul style="list-style-type:none;">
                                    <li><?php echo __('if $\mathcal{R} \subseteq closure(X)$:'); ?>
                                        <ul style="list-style-type:none;">
                                            <?php echo __('$X$ is superkey'); ?>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </p>
                    
                    <p>
                        <?php echo __('We can extend the definition of a super key by demanding minimality:'); ?>
                    </p>
                    
                    <p>
                        <b><?php echo __('Definition.'); ?></b> <?php echo __('A candidate key $K \subseteq \mathcal{R}$ is a minimal super key that is there exist no subset of $K\' \subseteq K$ such that $K\'$ is super key.'); ?>
                    </p>
                    
                    <p>
                        <?php echo __('Now that we have the basic terminology we can speak about normal forms.'); ?>
                    </p>
                    
                    <p>
                        <b><?php echo __('Definition.'); ?></b> <?php echo __('A relational scheme is in first normal form if the domains of all attributes are atomic.'); ?>
                    </p>
                    
                    <p>
                        <b><?php echo __('Remark.'); ?></b> <?php echo __('In our definition of a relational scheme all domains are atomic, thus for us all relational schemes are in first normal form.'); ?>
                    </p>
                    
                    <p>
                        <?php echo __('An attribute $X$ is set to be fully functional dependant on the set of attributes $A$ if $A \rightarrow X$ and there exists no subset $A\' \subseteq A$ such that $A \rightarrow X$. We will use this new concept for introducing the second normal form.'); ?>
                    </p>
                    
                    <p>
                        <b><?php echo __('Definition.'); ?></b> <?php echo __('A relational scheme is in second normal form if every non key attribute is fully functional dependant on every candidate keys.'); ?>
                    </p>
                    
                    <p>
                        <?php echo __('By non key attribute we denote all attributes which are not part of an arbitrary candidate key.'); ?>
                    </p>
                    
                    <p>
                        <b><?php echo __('Definition.'); ?></b> <?php echo __('A relational scheme is in third normal form if for every functional dependency $A \rightarrow X$ with $A \subseteq \mathcal{R}$ and $X \in \mathcal{R}$ one of the following conditions holds:'); ?>
                    </p>
                    
                    <ul>
                        <li><?php echo __('The functional dependency is trivial.'); ?></li>
                        <li><?php echo __('$A$ is a super key.'); ?></li>
                        <li><?php echo __('$X$ is part of a candidate key.'); ?></li>
                    </ul>
                    
                    <p>
                        <?php echo __('We can check for both second and third normal form by simply finding a counterexample.'); ?>
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>