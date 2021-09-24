<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4938d2d8e6715c386d4a92f108cdca0f
{
    public static $files = array (
        'e72a6b6344e381d932872f023c7c431c' => __DIR__ . '/../..' . '/includes/functions.php',
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'NCB_Container' => __DIR__ . '/../..' . '/includes/class-ncb-container.php',
        'NCB_EJS_Queue' => __DIR__ . '/../..' . '/includes/class-ncb-ejs-queue.php',
        'NCB_Hooks_Impl' => __DIR__ . '/../..' . '/includes/trait-ncb-hooks-impl.php',
        'NCB_Layout' => __DIR__ . '/../..' . '/includes/interface-ncb-layout.php',
        'NCB_Layout_Plugin' => __DIR__ . '/../..' . '/includes/class-ncb-layout-plugin.php',
        'NCB_Layout_Theme' => __DIR__ . '/../..' . '/includes/class-ncb-layout-theme.php',
        'NCB_Module' => __DIR__ . '/../..' . '/includes/class-ncb-module.php',
        'NCB_Pool' => __DIR__ . '/../..' . '/includes/class-ncb-pool.php',
        'NCB_Reg' => __DIR__ . '/../..' . '/includes/interface-ncb-reg.php',
        'NCB_Reg_AJAX' => __DIR__ . '/../..' . '/includes/regs/class-ncb-reg-ajax.php',
        'NCB_Reg_Item' => __DIR__ . '/../..' . '/includes/interface-ncb-reg-item.php',
        'NCB_Reg_Item_AJAX' => __DIR__ . '/../..' . '/includes/reg-items/class-ncb-reg-item-ajax.php',
        'NCB_Reg_Item_Script' => __DIR__ . '/../..' . '/includes/reg-items/class-ncb-reg-item-script.php',
        'NCB_Reg_Item_Shortcode' => __DIR__ . '/../..' . '/includes/reg-items/class-ncb-reg-item-shortcode.php',
        'NCB_Reg_Item_Style' => __DIR__ . '/../..' . '/includes/reg-items/class-ncb-reg-item-style.php',
        'NCB_Reg_Script' => __DIR__ . '/../..' . '/includes/regs/class-ncb-reg-script.php',
        'NCB_Reg_Shortcode' => __DIR__ . '/../..' . '/includes/regs/class-ncb-reg-shortcode.php',
        'NCB_Reg_Style' => __DIR__ . '/../..' . '/includes/regs/class-ncb-reg-style.php',
        'NCB_Register_Meta' => __DIR__ . '/../..' . '/includes/regs/abstract-class-ncb-register-meta.php',
        'NCB_Register_Option' => __DIR__ . '/../..' . '/includes/regs/class-ncb-register-option.php',
        'NCB_Register_Post_Meta' => __DIR__ . '/../..' . '/includes/regs/class-ncb-register-post-meta.php',
        'NCB_Register_Post_Type' => __DIR__ . '/../..' . '/includes/regs/class-ncb-register-post-type.php',
        'NCB_Register_Submit' => __DIR__ . '/../..' . '/includes/regs/class-ncb-registr-submit.php',
        'NCB_Register_Taxonomy' => __DIR__ . '/../..' . '/includes/regs/class-ncb-register-taxonomy.php',
        'NCB_Register_Term_Meta' => __DIR__ . '/../..' . '/includes/regs/class-ncb-register-term-meta.php',
        'NCB_Registrable_Meta' => __DIR__ . '/../..' . '/includes/reg-items/class-ncb-registrable-meta.php',
        'NCB_Registrable_Option' => __DIR__ . '/../..' . '/includes/reg-items/class-ncb-registrable-option.php',
        'NCB_Registrable_Post_Type' => __DIR__ . '/../..' . '/includes/reg-items/class-ncb-registrable-post-type.php',
        'NCB_Registrable_Submit' => __DIR__ . '/../..' . '/includes/reg-items/class-ncb-registrable-submit.php',
        'NCB_Registrable_Taxonomy' => __DIR__ . '/../..' . '/includes/reg-items/class-ncb-registrable-taxonomy.php',
        'NCB_Regs' => __DIR__ . '/../..' . '/includes/class-ncb-regs.php',
        'NCB_Render_Impl' => __DIR__ . '/../..' . '/includes/trait-ncb-render-impl.php',
        'NCB_Submodule_Impl' => __DIR__ . '/../..' . '/includes/trait-ncb-submodule-impl.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit4938d2d8e6715c386d4a92f108cdca0f::$classMap;

        }, null, ClassLoader::class);
    }
}
