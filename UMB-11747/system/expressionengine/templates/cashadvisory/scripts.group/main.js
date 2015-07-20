// Banner Tabs handling
$('.banner-tab-label').click(function(e) {
    e.preventDefault();

    var $label = $(this).closest('li');
    var $tab = $($(this).attr('href'));

    var $activeTab = $tab.siblings('.active');
    var $activeLabel = $label.siblings('.active');

    $activeLabel.removeClass('active');
    $label.addClass('active');

    $activeTab.fadeOut(1000).removeClass('active');
    $tab.fadeIn(1000).addClass('active');
});