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
<?php foreach ($functions as $function => $exists): ?>
    - function <?php echo $function; ?> <?php $exists ? 'exists' : 'does not exist'; ?>
<?php endforeach; ?>

## Known Plugin / Theme Conflicts
<?php foreach ($conflicts as $conflict): ?>
    - plugin <?php echo $conflict; ?> is active.
<?php endforeach; ?>
<?php if ( 0 === count( $conflicts ) ): ?>
    - No known conflicts found.
<?php endif; ?>

<?php if (isset($post_id)): ?>
    ## Cache Options metabox
    Note: You’re viewing post ID <?php echo $post_id; ?>
    - This post is <?php echo $excluded ? 'EXCLUDED from caching via “Never cache this page”, or “Never cache (URL)”' : 'not excluded from caching via “Never cache this page”, or “Never cache (URL)”'; ?>
    <?php foreach ($metaboxes as $metabox => $value): ?>
            - Cache option <?php echo $metabox; ?>: <?php echo $value  ? 'DEACTIVATED' : 'unchanged'; ?>
            <?php if ('minify_html' === $metabox): ?>
            (Remember: Minify HTML is dynamically disabled, so this debug notice can be displayed.)
            <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>
####################################################
-->