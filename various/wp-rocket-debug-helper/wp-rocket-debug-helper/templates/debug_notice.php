<!--
####################################################
## WP ROCKET DEBUG ##

Note: Minify HTML is dynamically disabled, so this debug notice can be displayed.

## Constants

<?php foreach ($constants as $constant => $value): ?>
    - constant <?php echo $constant; ?> is: <?php echo $value; ?>
<?php endforeach; ?>

## Filters
Note: Filter `rocket_override_donotcachepage` gets set by WP Rocket core in certain environments.
<?php foreach ($filters as $filter => $callbacks): ?>
    - filter <?php echo $filter; ?> is: <?php echo $callbacks; ?>
<?php endforeach; ?>

## Functions

####################################################
-->