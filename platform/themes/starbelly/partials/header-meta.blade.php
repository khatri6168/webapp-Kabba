{!! BaseHelper::googleFonts('https://fonts.googleapis.com/css2?family=' . theme_option('secondary_font', 'Monoton') . '&family=' . urlencode(theme_option('primary_font', 'Rubik')) . ':wght@300;400;500;600;700;800;900&display=swap') !!}

<style>
    :root {
        --primary-color: {{ theme_option('primary_color', '#F5C332') }};
        --top-bar-color: {{ theme_option('top_bar_color', '#EAEAEA') }};
        --primary-font: '{{ theme_option('primary_font', 'Rubik') }}', sans-serif;
        --secondary-font: '{{ theme_option('secondary_font', 'Monoton') }}', sans-serif;
    }
</style>
