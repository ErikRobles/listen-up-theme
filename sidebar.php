<aside class="w-full mt-3 md:mt-8 md:w-[20%] mb-5">       
    <?php 
        if(is_active_sidebar('sidebar')) :
            dynamic_sidebar('sidebar'); 
        endif;
    ?>
</aside>