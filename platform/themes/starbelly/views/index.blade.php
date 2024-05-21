@php Theme::layout('homepage') @endphp

<div class="container">
    <div style="margin: 170px 0;">
        <h4 style="color: #f00">You need to setup your homepage first!</h4>
        <br>

        <p><strong>1. Go to Admin -> Plugins then activate all plugins.</strong></p>
        <p><strong>2. Go to Admin -> Pages and create a page:</strong></p>

        <div style="margin: 20px 0;">
            <div>- Content:</div>
            <div style="border: 1px solid rgba(0,0,0,.1); padding: 10px; margin-top: 10px;direction: ltr;">
                <div>[hero-banner style="1" title="We do not cook, we create your emotions!" subtitle="Consecrate numeral port nemo venial diligent rem disciple quo mod." text_secondary="Hi, new friend!" image="backgrounds/girl.png" button_label_1="Our menu" button_url_1="/shop-1" button_label_2="About us" button_url_2="/about-us"][/hero-banner]') .
                <div>[our-features title="We are doing more than you expect" title_1="We are located in the city center" subtitle_1="Porto nemo venial necessitates presentiment diligent rem temporise disciple quo mod numeral." title_2="Fresh, organic ingredients" subtitle_2="Consectetur numquam porro nemo veniam necessitatibus praesentium eligendi rem temporibus adipisci quo modi." title_3="Own fast delivery" subtitle_3="Necessitatibus praesentium eligendi rem temporibus adipisci quo modi. Lorem ipsum dolor sit." image="backgrounds/interior.jpg" year_experience="2"][/our-features]</div>
                <div>[featured-categories title="What do you like today?" subtitle="Consecrate numeral port nemo venial diligent rem disciple quo mod." category_ids="1,2,3,4" button_label="Shop now" button_url="/shop-1"][/featured-categories]</div>
                <div>[products-list title="Most popular dishes" subtitle="A great platform to buy, sell and rent your properties without any agent or commissions." type="feature" style="slide" items_on_slide="3" limit="6" footer_style="rating" button_label="Shop now" button_url="/shop-1" button_icon="general/menu.png"][/products-list]</div>
                <div>[apps-download title="Download our mobile app." subtitle="Consecrate numeral port nemo venial diligent rem disciple quo mod." image="backgrounds/phones.png" platform_button_image_1="platforms/android.png" platform_url_1="https://play.google.com/store" platform_button_image_2="platforms/ios.png" platform_url_2="https://www.apple.com/store"][/apps-download]</div>
                <div>[team title="They will cook for you" subtitle="Consecrate numeral port nemo venial diligent rem disciple quo mod." team_ids="1,2,3,4" limit="4" button_label="Open menu" button_icon="general/menu.png" button_url="/shop-1"][/team]</div>
                <div>[flash-sale-popup flash_sale_ids="1" description="Et modi itaque praesentium" timeout="5"][/flash-sale-popup]</div>
            </div>
            <br>
            <div>- Template: <strong>Homepage</strong>.</div>
        </div>

        <br>
        <p><strong>3. Then go to Admin -> Appearance -> Theme options -> Page to set your homepage.</strong></p>
    </div>
</div>
