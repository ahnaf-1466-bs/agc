<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 *
 * @package   theme_mb2nl
 * @copyright 2017 - 2022 Mariusz Boloz (mb2moodle.com)
 * @license   Commercial https://themeforest.net/licenses
 *
 */


defined('MOODLE_INTERNAL') || die();


// Message displayed to the user when they choose this theme.
$string['choosereadme'] = 'Hey, I\'m New Learning';


// Human readable name of the plugin.
$string['pluginname'] = 'New Learning';


// Global
$string['bold'] = 'Bold';
$string['bolder'] = 'Bolder';
$string['bottom'] = 'Bottom';
$string['center'] = 'Center';
$string['justify'] = 'Distribute items evenly';
$string['dark'] = 'Dark';
$string['ddmenu'] = 'Drop Down menu';
$string['default'] = 'Default';
$string['description'] = 'Description';
$string['fade'] = 'Fade';
$string['general'] = 'General';
$string['global'] = 'Global';
$string['header'] = 'Header';
$string['headings'] = 'Headings';
$string['hide'] = 'Hide';
$string['icon'] = 'Icon';
$string['icondesc'] = 'Glyphicon, Font Awesome or PE-icon-7-stroke icon name, e.g. \'fa-envelope\'.';
$string['image'] = 'Image';
$string['inherit'] = 'Inherit';
$string['left'] = 'Left';
$string['light'] = 'Light';
$string['lighter'] = 'Lighter';
$string['link'] = 'Link';
$string['links'] = 'Links';
$string['margindesc'] = 'Margin: top right bottom left.';
$string['menu'] = 'Menu';
$string['menu'] = 'Menu';
$string['name'] = 'Name';
$string['no'] = 'No';
$string['none'] = 'None';
$string['normal'] = 'Normal';
$string['openlink'] = 'Open Link';
$string['openlinkblank'] = 'In a new window';
$string['openlinkself'] = 'In the same window';
$string['options'] = 'Options';
$string['ordering'] = 'Ordering';
$string['orderingdesc'] = 'Leave it empty to use default ordering.';
$string['right'] = 'Right';
$string['settingslink'] = 'Theme Settings';
$string['show'] = 'Show';
$string['slide'] = 'Slide';
$string['style'] = 'Style';
$string['subtitle'] = 'Sub Title';
$string['text'] = 'Text';
$string['textdesc'] = 'Optional text.';
$string['title'] = 'Title';
$string['top'] = 'Top';
$string['url'] = 'Url';
$string['yes'] = 'Yes';
$string['loading'] = 'Loading...';


// Check plugins
$string['checkplugins'] = 'To finish installation:';
$string['mb2shortcodes_filter_plugin_installed'] = 'Go to: <strong><em>Site administration &rarr; Plugins &rarr; Install plugins</em></strong> and INSTALL the <strong>FILTER_mb2shortcodes-x.x.x.zip</strong> file.';
$string['mb2shortcodes_filter_plugin'] = 'Go to: <strong><em>Site administration &rarr; Plugins &rarr; Filters &rarr; Manage filters</em></strong> and ACTIVATE the <strong>Mb2 Shortcodes</strong> filter.';
$string['urltolink_filter_plugin'] = 'Go to: <strong><em>Site administration &rarr;  Plugins &rarr; Filters &rarr; Manage filters</em></strong> and MOVE the <strong>Mb2 Shortcodes</strong> filter ABOVE the <strong>Convert URLs into links and images</strong> plugin.';
$string['mb2slides_plugin'] = '<strong>Mb2 Slides</strong> plugin must be installed.';
$string['mb2slides_plugin_empty'] = 'Mb2 Slides plugin is installed! Go to plugin page to <a href="{$a->link}">Manage slides</a>.';


// Regions
$string['region-adminblock'] = 'Adminblock';
$string['region-after-slider'] = 'After Slider';
$string['region-after-content'] = 'After Content';
$string['region-before-content'] = 'Before Content';
$string['region-side-pre'] = 'Side Pre';
$string['region-side-post'] = 'Side Post';
$string['region-slider'] = 'Slider';
$string['region-bottom'] = 'Bottom';
$string['region-bottom-a'] = 'Bottom A';
$string['region-bottom-b'] = 'Bottom B';
$string['region-bottom-c'] = 'Bottom C';
$string['region-bottom-d'] = 'Bottom D';
$string['region-content-top'] = 'Content Top';
$string['region-content-bottom'] = 'Content Bottom';


// Frontend
$string['foldernoexists'] = 'Images folder does not exists.';
$string['folderisempty'] = 'Images folder is empty.';
$string['adminblockinfo'] = 'Blocks placed in this region will be visible only for admin users.';
$string['entercourse'] = 'Enter this course';
$string['showsidebar'] = 'Show sidebars';
$string['hidesidebar'] = 'Hide sidebars';
$string['recyclebin'] = 'Recycle bin';
$string['eventmonitoring'] = 'Event monitoring';
$string['livelogs'] = 'Live logs';
$string['courseparticipation'] = 'Course participation';
$string['coursemanagement'] = 'Course management';
$string['coursedashboard'] = 'Course dashboard';
$string['studentsandyou'] = '{$a->students} and you';
$string['xmoreteachers'] = 'and {$a->teachers} more';
$string['popularlinks'] = 'Popular links:';
$string['readmore'] = 'Read more';
$string['frontpagebuilder'] = 'Front page builder';
$string['hidden'] = 'Hidden';
$string['noprice'] = 'Free';
$string['nocourseincategory'] = 'No courses';
$string['mybookmarks'] = 'Bookmarks';
$string['wentwrong'] = 'Something went wrong';
$string['bkmarklimit'] = 'You may add up to {$a->limit} bookmarks';
$string['layoutgrid'] = 'Grid';
$string['layoutlist'] = 'List';
$string['certificate'] = 'Certificate';
$string['register'] = 'Register';
$string['strftimedatemonthabbr'] = '%d %b %Y';
$string['strftimedatemoncourselist'] = '%d %b';
$string['strftimedatecourseupdated'] = '%b %Y';
$string['price'] = 'Price';
$string['paid'] = 'Paid';
$string['instructors'] = 'Instructors';
$string['bestseller'] = 'Bestseller';
$string['categorydesc'] = 'Category description';
$string['explorecategory'] = 'View all courses in category: {$a->category}';
$string['preformanceproblems'] = 'Problems';
$string['diskusage'] = 'Disk usage';
$string['onlineusers'] = 'Online users';
$string['lasthour'] = 'Last hour';
$string['emptycategories'] = 'Empty categories';
$string['activemodules'] = 'Active modules';
$string['activequizzes'] = 'Active quizzes';
$string['enrolform_course_code'] = 'Enrolment Code';
$string['skipel'] = 'Skip {$a->skipel}';
$string['skiptonavigation'] = 'Skip to navigation';
$string['skiptosearch'] = 'Skip to search form';
$string['skiptologin'] = 'Skip to login form';
$string['skiptoprofile'] = 'Skip to profile';
$string['skiptofooter'] = 'Skip to footer';
$string['slidernavprev'] = 'Move to the previous slide';
$string['slidernavnext'] = 'Move to the next slide';
$string['onthispage'] = 'On this page';
$string['sidebar'] = 'Sidebar';
$string['togglemenu'] = 'Toggle primary menu';
$string['togglemenuitem'] = 'Toggle submenu of {$a->menuitem}';
$string['togglesearch'] = 'Toggle search form';
$string['toggleheadercontent'] = 'Toggle extra content';
$string['bynameondate'] = '<span class="online">Posted on <span>{$a->date}</span></span> <span class="byline">by <span>{$a->name}</span></span>';
$string['eventdateshort'] = '<span class="month">%b</span> <span class="day">%d</span>';
$string['eventhourdate'] = '<span class="dtime">%I:%M <span class="pm-am">%p</span></span>';
$string['eventdaydate'] = '<span class="dtime">%a, %d %b %I:%M <span class="pm-am">%p</span></span>';
$string['yourprogress'] = 'Your progress';
$string['lightboxvideo'] = 'Video in lightbox: {$a->videourl}';
$string['courseintrovideo'] = 'Course introduction video';
$string['reviews'] = 'Reviews';
$string['overview'] = 'Overview';
$string['continuewith'] = 'Continue with {$a}';
$string['highlighted'] = 'Highlighted';
$string['loadmore'] = 'Load more posts';
$string['continuereading'] = 'Continue reading';
$string['togglecategory'] = 'Toggle subcategory of {$a}';

// Settings tabs
$string['configtitle'] = 'New Learning';
$string['settingsgeneral'] = 'General';
$string['settingscourses'] = 'Courses';
$string['settingsfeatures'] = 'Features';
$string['settingsnav'] = 'Menus';
$string['settingssocial'] = 'Social';
$string['settingsfonts'] = 'Font';
$string['settingstypography'] = 'Typography';
$string['settingsstyle'] = 'Style';
$string['allsettings'] = 'All settings';
$string['accessibility'] = 'Accessibility';

// Settings panel
$string['documentation'] = 'Documentation';
$string['morethemes'] = 'More Themes';
$string['urldoc'] = 'mb2moodle.com/docs/new-learning';
$string['urlmore'] = 'https://themeforest.net/user/marbol2/portfolio';

// Settings courses
$string['courseslist'] = 'Course list';
$string['coursesettings'] = 'Course';
$string['courseprice'] = 'Course price';
$string['coursinstructor'] = 'Course instructor';
$string['excludecat'] = 'Exclude category ID\'s';
$string['exctags'] = 'Exclude tag ID\'s';
$string['enrollmentpage'] = 'Course enrolment page';
$string['coursepage'] = 'Course page';
$string['layoutn'] = 'Layout {$a->layout}';
$string['showmorebtn'] = 'More/less button';
$string['elrollsections'] = 'Course sections';
$string['shareicons'] = 'Share icons';
$string['sharefacebook'] = 'Facebook';
$string['sharetwitter'] = 'Twitter';
$string['sharelinkedin'] = 'LinkedIn';
$string['shareemail'] = 'Email';
$string['shareurl'] = 'URL';
$string['quickview'] = 'Quick view';
$string['expiredcourses'] = 'Expired courses';
$string['courseplaceholder'] = 'Course placeholder image';
$string['cbtntext'] = 'Course button text';
$string['fullscreenmod'] = 'Full screen';
$string['coursetoc'] = 'Table of contents';
$string['tocsep'] = 'Table of contents separator';
$string['coursenav'] = 'Course custom navigation';
$string['c2cols'] = 'Two columns layout';
$string['cvideo'] = 'Course video';
$string['csection'] = 'Custom field section';
$string['enrolbtn'] = 'Always show enrol button';
$string['togglecat'] = 'Category toggle list';

// Settings general
$string['logo'] = 'Logo and favicon';
$string['favicon'] = 'Favicon';
$string['logoimg'] = 'Logo';
$string['logodarkimg'] = 'Logo dark';
$string['logoimgsm'] = 'Logo small';
$string['logodarkimgsm'] = 'Logo small dark';
$string['logoh'] = 'Logo height (px)';
$string['logohsm'] = 'Logo small height (px)';
$string['logohdesc'] = 'Logo height in pixels. Logo width will be set automatically.';
$string['pagewidth'] = 'Page width (px)';
$string['sidebarpos'] = 'Sidebars position';
$string['classic'] = 'Classic';
$string['layout'] = 'Layout';
$string['layoutfw'] = 'Full width';
$string['layoutfx'] = 'Boxed';
$string['footer'] = 'Footer';
$string['footer_desc'] = 'Skip all options below if you select footer from the Footer Builder.';
$string['foottext'] = 'Footer Content';
$string['partnerlogos'] = 'Partner logos';
$string['partnerslinks'] = ' Partner links';
$string['partnerslinksdesc'] = 'Each line consists separated by pipe characters (|):partner name|url::"1" to open link in a new window.<br>For example:<pre>Parnter #1 name|http://example.com
Parnter #2 name|http://example.com::1</pre>';
$string['coursestudentscount'] = 'Enroled students';
$string['coursedate'] = 'Course date';
$string['coursestartdate'] = 'Course start date';
$string['coursemodifieddate'] = 'Course modified date';
$string['coursecustomfields'] = 'Course custom fields';
$string['faviconimg'] = 'Favicon';
$string['favicondesc'] = 'Upload favicon image in "ico" format.';
$string['coursescls'] = 'Course Css Class';
$string['coursesclsdesc'] = 'Custom css class for courses. Css class for each course ("courseID:className") must be placed in a new line.';
$string['cbannerstyle'] = 'Course banner';
$string['sidebarbtn'] = 'Show/hide sidebars';
$string['sidebarbtntext'] = 'Text sidebar button';
$string['sidebaryesshow'] = 'Yes and show sidebars';
$string['sidebaryeshide'] = 'Yes and hide sidebars';
$string['courseswitchlayout'] = 'Course list layout switcher';
$string['coursegrid'] = 'Course list grid';
$string['headercontent'] = 'Header content';
$string['headercontentdesc'] = 'Each line consists separated by pipe characters (|):<br>text::optional icon name|optional url::"1" to open link in a new window|language code or comma-separated codes|"1" to show text for logged in users only or "2" to show text for none logged in users only.<br>For example:<pre>Text with icon::fa-life-ring
Link with icon open in a new window::fa-link|http://example.com::1
English text||en
Spanish link text|http://example.com|es
English and Spanish text||en,es
Text for logged in users|||1
Text for guests|||2</pre>';
$string['headerbtn'] = 'Header buttons';
$string['headerbtndesc'] = 'Each line consists separated by pipe characters "|":<br>button text|url::"1" to open link in a new window|language code or comma-separated codes|"1" to show text for logged in users only or "2" to show text for guests only.<br>For example:<pre>For guests|http://example.com||2
For users|http://example.com||1</pre>';
$string['editingfw'] = 'Full width content on editing mode';
$string['frontpage'] = 'Front page';
$string['slider'] = 'Slider';
$string['transparent'] = 'Transparent';
$string['transparent_light'] = 'Transparent light';
$string['h_pagetitle'] = 'Page title section';


$string['headernav'] = 'Main menu in header';
$string['headertoolstext'] = 'Text buttons';
$string['customfooter'] = 'Custom footer';
$string['fp2course'] = 'Redirect to courses page';


// Settings navigation
$string['stickynav'] = 'Sicky navigation';
$string['stickymobilenav'] = 'Sticky navigation on mobile';
$string['navddwidth'] = 'Dropdown list width (px)';
$string['mycinmenu'] = 'My courses in menu';
$string['mychidden'] = 'Hidden courses';
$string['myclimit'] = 'Course name words limit';
$string['navicon'] = 'Icon navigation';
$string['urlnw'] = 'Open in a new window';
$string['mainmenu'] = 'Main menu';
$string['naviconsdesc'] = 'Each line consists separated by pipe characters (|):<br>text::icon name|optional url::"1" to open link in a new window|language code or comma-separated codes|"1" to show text for logged in users only or "2" to show text for none logged in users only.<br>For example:<pre>Link with icon::fa-life-ring|http://example.com
Link with icon open in a new window::fa-link|http://example.com::1
English text::fa-flag||en
Spanish link text::fa-star|http://example.com|es
English and Spanish text::fa-globe||en,es
Text for logged in users::fa-lock|||1
Text for guests::fa-unlock|||2</pre>';
$string['homeitem'] = 'Home item';
$string['navalign'] = 'Alignment';
$string['navcolor'] = 'Menu item color';
$string['navhcolor'] = 'Menu item hover color';
$string['navhbgcolor'] = 'Menu item hover background color';
$string['navbarbgcolor'] = 'Navigation bar background color';
$string['navsubcolor'] = 'Menu item subtext color';
$string['navsubhcolor'] = 'Menu item subtext hover color';

// Settings social
$string['socillist'] = 'Social icons';
$string['socialheader'] = 'Header icons';
$string['socialfooter'] = 'Footer icons';
$string['sociallinknw'] = 'Open links in a new widnow';
$string['socialtt'] = 'Tooltip';
$string['socialmargin'] = 'Icon list top margin (px)';


// Settings features
$string['loadingscreen'] = 'Loading screen';
$string['spinnerw'] = 'Spinner image size (px)';
$string['ganaid'] = 'Tracking ID';
$string['ganaiddesc'] = 'Google Analytics tracking ID: "UA-XXXXX-Y"';
$string['ganatitle'] = 'Tracking code';
$string['ganaasync'] = 'Alternative Async Tracking';
$string['loginform'] = 'Login Form';
$string['loginsearchform'] = 'Login and search form';
$string['loginpage'] = 'Custom login page';
$string['forgotpage'] = 'Forgot password/username page';
$string['signuplink'] = 'Register button';
$string['signuppage'] = 'Custom register page url';
$string['quicklinks'] = 'Quick links';
$string['teacherroleshortname'] = 'Teacher role shortname';
$string['studentroleshortname'] = 'Student role shortname';
$string['teacheremail'] = 'Teacher email';
$string['teachermessage'] = 'Teacher message link';
$string['coursepanel'] = 'Course panel';
$string['excludedlinks'] = 'Excluded items';
$string['customquicklinkitems'] = 'Custom quick link items';
$string['excludedlinksdesc'] = 'Comma separated items which you want to exclude from the quick links menu: <ul><li>dashboard - my dashboard page</li><li>frontpage - front page</li><li>calendar - calendar page</li><li>badges - my badges page</li><li>mycourses - my courses page (Moodle 4+)</li><li>courses - all courses page</li><li>addcourse - new course page</li><li>addcategory - new category page</li><li>editcourse - course edit page</li><li>editcategory - category edit page</li></ul>';
$string['cpaneldesclimit'] = 'Course Description Words Limit';
$string['searchlinks'] = 'Popular Links';
$string['searchlinksdesc'] = 'Each line consists separated by pipe characters (|):<br>link text|url::"1" to open link in a new window|language code or comma-separated codes|"1" to show text for logged in users only or "2" to show text for none logged in users only.<br>For example:<pre>Link text|http://example.com
Link open in a new window|http://example.com::1
English link text text|http://example.com|en
Spanish link text|http://example.com|es
English and Spanish link text|http://example.com|en,es
Link for logged in users|http://example.com||1
Link for guests|http://example.com||2</pre>';
$string['loginlinktopage'] = 'Link to Login Page';
$string['bookmarks'] = 'Bookmarks';
$string['bookmarkslimit'] = 'Bookmarks Limit';
$string['customquicklinkitemsdesc'] = 'Each line consists separated by pipe characters (|):<br>text::icon name|url::"1" to open link in a new window|language code or comma-separated codes.<br>For example:<pre>Link text::fa-life-ring|http://example.com</pre>';
$string['certificatestr'] = 'Certificate String';
$string['certificatelinks'] = 'Custom Certificate Links';
$string['certificatelinksdesc'] = 'Each line consists separated by pipe characters (|) course_ID|certificate_url. For example:<br><pre>2|https://www.accredible.com/000001</pre>';
$string['langinmenu'] = 'Languages';
$string['language'] = 'Language';
$string['langpos'] = 'Language position';
$string['lang1'] = 'Main menu';
$string['lang2'] = 'Footer';
$string['modaltools'] = 'Login and search form in modal window';
$string['autologinguestsanypage'] = 'Auto-login guests on any page';
$string['blogplaceholder'] = 'Blog entry placeholder image';
$string['blogsettings'] = 'Blog';
$string['activeuserstime'] = 'User active time (months)';
$string['newuserstime'] = 'User new time (days)';
$string['dateformat'] = 'Date format';
$string['blogintro'] = 'Intro text';
$string['blogmodify'] = 'Last modified date';
$string['blogfeaturedmedia'] = 'Featured media';
$string['eventsplaceholder'] = 'Event placeholder image';
$string['contrastdark'] = 'Dark contrast';
$string['highcontrast'] = 'High contrast';
$string['highsaturation'] = 'High saturation';
$string['lowsaturation'] = 'Low saturation';
$string['monochrome'] = 'Monochrome';
$string['coloradjustments'] = 'Color adjustments';
$string['contentadjustments'] = 'Content adjustments';
$string['readablefont'] = 'Readable font';
$string['orientationadjustments'] = 'Orientation adjustments';
$string['readingmask'] = 'Reading Mask';
$string['bigblackcursor'] = 'Big black cursor';
$string['bigwhitecursor'] = 'Big white cursor';
$string['acsbtextsize'] = 'Text size';
$string['demoimage'] = 'https://dummyimage.com/{$a->size}/eeeeee/333333.jpg';
$string['highlighttitles'] = 'Highlight titles';
$string['highlightlinks'] = 'Highlight links';
$string['seizureandepileptic'] = 'Seizure and epileptic';
$string['adhd'] = 'ADHD';
$string['visualimpairment'] = 'Visual impairment';
$string['colorvisiondeficiency'] = 'Color vision deficiency';
$string['learning'] = 'Learning';
$string['resetsettings'] = 'Reset settings';
$string['stopanimations'] = 'Stop animations';
$string['contrastlight'] = 'Light contrast';
$string['acsblineheight'] = 'Line height';
$string['textspacing'] = 'Text spacing';
$string['readingguide'] = 'Reading guide';
$string['acsbplus'] = '{$a->adj}: plus {$a->time}';
$string['acsboptions'] = 'Accessibility options';
$string['acsbprofiles'] = 'Accessibility profiles';
$string['blogmore'] = 'Load more button';
$string['blogpage'] = 'Blog page';
$string['blogsinglepage'] = 'Single post page';
$string['xcolumns'] = '{$a} columns';

// Settings fonts
$string['ficonfa'] = 'Font Awesome';
$string['ficon7stroke'] = 'Stroke Icons 7';
$string['gfonts'] = 'Google Web Fonts';
$string['nfonts'] = 'Normal Fonts';
$string['nfont'] = 'Normal Font';
$string['gfont'] = 'Google Fonts';
$string['fontname'] = 'Font Name';
$string['fontstyle'] = 'Font Style';
$string['fontsubset'] = 'Font Subset';
$string['cfont'] = 'Custom fonts';
$string['cfontname'] = 'Font name';
$string['cfontfiles'] = 'Font files';
$string['cfontfilesdesc'] = 'Upload font files in the following formats: woff2, woff, ttf.';


// Settings style
$string['colors'] = 'Colors';
$string['accentcolor'] = 'Accent color';
$string['textcolor'] = 'Text color';
$string['textcolor_lighten'] = 'Text color lighter';
$string['textcolorondark'] = 'Text color on dark background';
$string['linkcolor'] = 'Links color';
$string['linkhcolor'] = 'Links hover color';
$string['headingscolor'] = 'Headings color';
$string['pagestyle'] = 'Page';
$string['bgcolor'] = 'Background color';
$string['lbgcolor'] = 'Light background color';
$string['dbgcolor'] = 'Dark background color';
$string['tbdbgcolor'] = 'Top bar dark background color';
$string['bgimage'] = 'Background image';
$string['bgpos'] = 'Background position';
$string['bgsize'] = 'Background size';
$string['bgrepeat'] = 'Background repeat';
$string['bgattachment'] = 'Background attachment';
$string['pbgdesc'] = 'To see page background color or image you need ot use \'Boxed\' page layout.';
$string['strip1'] = 'Strip left light';
$string['strip2'] = 'Strip left dark';
$string['pbgpre'] = 'Predefined background';
$string['colorscheme'] = 'Color scheme';
$string['sectionpadding'] = 'Top,bottom padding';
$string['sectionpaddingdesc'] = 'Comma separated padding top and bottom in pixels, e.g. \'20,20\'.';
$string['imgdefault'] = 'Default image';
$string['headerstyleheading'] = 'Header';
$string['headerstyle'] = 'Header style';
$string['navbarplugin'] = 'Navbar plugin';
$string['scustomcssstyleheading'] = 'Custom css style';
$string['customcss'] = 'Custom css code';
$string['plugincss'] = 'Plugin style files';
$string['plugincssdesc'] = 'Each line consists plugin style file name.<br>You can set the following style file names:<pre>plugin-buttons
plugin-easy
plugin-grid
plugin-iomad
plugin-mb2sections
plugin-tiles
plugin-topcoll
</pre>';
$string['btnprimarycolor'] = 'Primary button color';
$string['btncolor'] = 'Default button color';
$string['pbgimagescroll'] = 'Scroll background';
$string['color_success'] = 'Color success';
$string['color_warning'] = 'Color warning';
$string['color_danger'] = 'Color danger';
$string['color_info'] = 'Color info';
$string['blockstyleheading'] = 'Blocks';
$string['blockstyle'] = 'Block style';
$string['minimal'] = 'Minimal';
$string['classic'] = 'Classic';


// Settings typography
$string['ffamily'] = 'Font';
$string['fsize'] = 'Font size (rem)';
$string['fsizepx'] = 'Font size (px)';
$string['fweight'] = 'Font weight';
$string['gfont'] = 'Google font';
$string['hsize'] = 'Heading {$a->hsize} size (rem)';
$string['ttransform'] = 'Text transform';
$string['uppercase'] = 'Uppercase';
$string['capitalize'] = 'Capitalize';
$string['lowercase'] = 'Lowercase';
$string['italic'] = 'Italic';
$string['oblique'] = 'Oblique';
$string['fweightlight'] = 'Font weight: light';
$string['fweightnormal'] = 'Font weight: normal';
$string['fweightmedium'] = 'Font weight: medium';
$string['fweightbold'] = 'Font weight: bold';
$string['medium'] = 'Medium';


// Settings pages
$string['cloginpage'] = 'Custom login page';

// Settings features
$string['loadingscr'] = 'Loading screen';
$string['loadingscrdesc'] = 'Loading screen is NOT visible for admin user.';
$string['loadinglogodesc'] = 'Leave it empty to use default logo on loading page.';
$string['loadinghide'] = 'Hide screen after (ms)';
$string['scrolltt'] = 'Scroll to top';
$string['scrollspeed'] = 'Scroll speed (ms)';

// Enrolment page
$string['enroltextprice'] = 'Enrol in course for <span class="price"><span class="currency" aria-hidden="true">{$a->currency}</span><span class="cost">{$a->cost}</span><span class="sr-only">{$a->sr_currency}</span></span>';
$string['enroltextfree'] = 'Enrol now';
$string['headingaboutcourse'] = 'About the course';
$string['headingwhatlearn'] = 'What you\'ll learn';
$string['headingrequirements'] = 'Requirements';
$string['headingsections'] = 'Course content';
$string['headinginstructors'] = 'Instructors';
$string['headingactivities'] = 'This course includes';
$string['headingsocial'] = 'Share this course';
$string['teachercourses'] = '{$a->courses} courses';
$string['teacherstudents'] = '{$a->students} students';
$string['alreadyenrolled'] = '{$a->students} already enrolled!';
$string['nobodyenrolled'] = 'Be the first to enrol!';
$string['strftimedatedaymonth'] = '%d %b';
$string['coursestarts'] = '<span class="date-label">Course starts</span> <span class="date">{$a->startdate}</span>';
$string['coursesupdated'] = '<span class="date-label">Last updated</span> <span class="date">{$a->updatedate}</span>';

// Deprecated strings
$string['pagelogin'] = 'Deprecated';
$string['socialmargindesc'] = 'Deprecated';
$string['naviconfsize'] = 'Deprecated';
$string['stickysitemenu'] = 'Deprecated';
$string['coursepanelpos'] = 'Deprecated';
$string['coursepanelpossitemenu'] = 'Deprecated';
$string['coursepanelposcontent'] = 'Deprecated';
$string['logom'] = 'Deprecated';
$string['panellinkincontent'] = 'Deprecated';
$string['stickyheader'] = 'Deprecated';
$string['region-banner-top'] = 'Deprecated';
$string['region-banner-bottom'] = 'Deprecated';
$string['mb2slider_plugin'] = 'Deprecated';
$string['mb2shortcodes_button_plugin'] = 'Deprecated';
$string['bcstyle'] = 'Deprecated';
$string['acstyle'] = 'Deprecated';
$string['asstyle'] = 'Deprecated';
$string['headercontentmt'] = 'Deprecated';
$string['langmargin'] = 'Deprecated';
$string['pagecls'] = 'Deprecated';
$string['pageclsdesc'] = 'Deprecated';
$string['coursecls'] = 'Deprecated';
$string['courseclsdesc'] = 'Deprecated';
$string['loginlink'] = 'Deprecated';
$string['cbannertitle'] = 'Deprecated';
$string['logow'] = 'Deprecated';
$string['logowdesc'] = 'Deprecated';
$string['headertoolstype'] = 'Deprecated';
$string['toolsicon'] = 'Deprecated';
$string['toolstext'] = 'Deprecated';
$string['studentsroleid'] = 'Deprecated';
$string['roleshortname'] = 'Deprecated';
$string['coursegridfp'] = 'Deprecated';
$string['coursegridcat'] = 'Deprecated';
$string['courseplimg'] = 'Deprecated';
$string['coursebtn'] = 'Deprecated';
$string['mycexpierd'] = 'Deprecated';
$string['blockstyledesc'] = 'Deprecated';
$string['regions'] = 'Deprecated';
$string['regionnogrid'] = 'Deprecated';
$string['logotitle'] = 'Deprecated';
$string['logotitledesc'] = 'Deprecated';
$string['logoalttext'] = 'Deprecated';
$string['logoalttextdesc'] = 'Deprecated';
$string['footlogin'] = 'Deprecated';
$string['morecat'] = 'Deprecated';
$string['moretags'] = 'Deprecated';
$string['moreinstructor'] = 'Deprecated';
$string['loginlogodesc'] = 'Deprecated';
$string['logintext'] = 'Deprecated';
$string['logininfo'] = 'Deprecated';
$string['fstyle'] = 'Deprecated';
$string['headerimg'] = 'Deprecated';
$string['headerbgcolor'] = 'Deprecated';
$string['celtypo'] = 'Deprecated';
$string['celsel'] = 'Deprecated';
$string['celseldesc'] = 'Deprecated';
$string['courseimg'] = 'Deprecated';
$string['navcls'] = 'Deprecated';
$string['navclsdesc'] = 'Deprecated';
$string['sitemenufp'] = 'Deprecated';
$string['sitemenu'] = 'Deprecated';
$string['sitemnuitems'] = 'Deprecated';
$string['customsitemnuitems'] = 'Deprecated';
$string['customsitemenudesc'] = 'Deprecated';
$string['sitemnuitemsdesc'] = 'Deprecated';
$string['enrollayout'] = 'Deprecated';
$string['sidebarposcourse'] = 'Deprecated';
$string['navatype'] = 'Deprecated';
$string['navaspeed'] = 'Deprecated';
$string['navatypefade'] = 'Deprecated';
$string['navatypeslide'] = 'Deprecated';