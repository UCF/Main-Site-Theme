# Known Issues

Below are general issues with the UCF.edu theme or the WordPress installation (as of version 3.4) which may impact the user experience in certain use cases.


## General
- Academics Search can occasionally chug, depending on the search query.  This is an issue on the search service's end.
- Transparent .gif images uploaded through the WordPress media library (as of WP 3.4) will generate thumbnails with black backgrounds, on what appears to be specific server configurations (this does not occur on Webcom, but occurs on Dev + QA.)  This appears to be a limitation with WordPress's image processing library.  To counteract this, upload transparent .gif images at the exact size of the thumbnail you wish to resize to, or use an alternative file format, such as .png.
- Centerpiece post previews have been disabled due to a bug with saving centerpiece media; if the 'Preview' button was clicked, any uploaded slide images would be wiped.  To preview centerpieces before they go live, publish the centerpiece with a non-immediate scheduled date (allow at least enough time to review your changes.)  If the centerpiece is good to be published, re-set the publish date to the current day/time.


## Browser-Specific
### IE (all)
- Publication thumbnails may appear stretched on older versions of IE due to `height: auto` not being fully supported; fixed widths/heights must be used for publication container divs and not all thumbnails fit exactly within the given dimensions.

### IE7
- A-Z Index: The navigation bar affixing has been disabled due to IE7 moving the navbar offscreen.


## Device/OS-Specific
### General Touch Devices
- Some Bootstrap elements, including navigation dropdowns, tend to be finicky on touch devices.  See the Bootstrap testing page for examples.

### Android 

#### 2.3 and older
- Elements that sit directly below dropdown menus become nearly impossible to touch correctly due to the clickable space of the dropdown being incorrectly stretched out far below its actual rendered space.  This is a bug with Android that doesn't currently have a fix.  Avoid placing dropdown menus directly above or next to other navigational elements.

#### v.??
- Clickable elements within modals will stop returning a response after the first click or not at all.  Tends to occur primarily in v2.3 and lower, but higher versions are occasionally wonky in BrowserStack.  A modal link fallback script has been implemented for Android browsers running v2.3 or lower to help bypass this problem; if a `src` value is found within a modal's content, that value is set as the `href` value of the modal's open link and modal functionality is disabled.

#### 1.5, 1.6
- Emergency Alert icons do not render correctly (appears to be a bug with setting a background image to the icon div; probably a background-size imcompatibility.)  Most v1.5/1.6 users likely won't ever encounter this problem because of the m.ucf.edu redirect, however.  (Tested on Sony Xperia X10 running 1.6, HTC Hero running 1.5) 