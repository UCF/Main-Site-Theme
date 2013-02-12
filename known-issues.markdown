# Known Issues

Below are general issues with the UCF.edu theme or the WordPress installation (as of version 3.4) which may impact the user experience in certain use cases.


## General
- Transparent .gif images uploaded through the WordPress media library (as of WP 3.4) will generate thumbnails with black backgrounds, on what appears to be specific server configurations (this does not occur on Webcom, but occurs on Dev + QA.)  To counteract this, upload transparent .gif images at the exact size of the thumbnail you wish to resize to (i.e., Spotlight images should be uploaded at exactly 110x110px), or use an alternative file format, such as .png.
- Due to the way that post previews and autosaving works and the way that we are saving Centerpiece image data, whenever a Centerpiece is previewed before its content is saved as a draft or is published, the Centerpiece's saved images (slides and video thumbnails) will get wiped.  To counteract this, new Centerpieces will display a note at the top of the editor's Publish box with instructions for saving and previewing Centerpieces (the user should save any changes as a Draft before clicking the 'Preview' button.)


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

#### 4.1, 4.2
- Dropdown `<select>` boxes render incorrectly, depending on the device.
	* Motorola Razr Maxx HD, Samsung Galaxy Nexus III, Samsung Galaxy Note II (all 4.1): no select arrow is rendered; styles have been modified to an extent to look acceptable.
	* Google Nexus 7 (4.1), LG Nexus 4 (4.2): select box has no padding (so the height of the select box is incorrect); no select arrow is rendered. Style modifications are ignored and there is not currently a known fix for this.