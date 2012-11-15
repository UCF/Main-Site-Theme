
/* QuickLinks Persistance and Rendering Classes */


// QuickLinksPersistance
// -----------------------------------------------
// Provides persistance implementation for Quicklinks
// Classes

var QuickLinksPersistance = $.klass({

	// Constructor
	initialize: function(cookieDomain) 
	{
		this.domain = cookieDomain;
		this.jar = new $.cookieJar('quicklinks',{  
			expires:630720000,   // seconds   
			domain: ".ucf.edu",
			path: '/'  
		});  
	this.quickLinkData = null;  
	},
	
	// Load Quicklinks data from cookie
	getQuickLinkData: function()
	{
				
		if (!this.quickLinkData){ this.quickLinkData = this.jar.get('quickLinkData');}
		if (!this.quickLinkData){ this.quickLinkData  = {links:[]};}
		this.sortAlpha(this.quickLinkData.links)
			
		return this.quickLinkData
	},
	
	// Save quicklinks data from cookie
	saveQuickLinkData: function()
	{
		
		// backup quicklinks
		oldQuickLinks = this.quickLinkData.links;
		
		result = this.jar.set('quickLinkData', this.quickLinkData);
		if (result == false)
		{
			this.quickLinkData.links = oldQuickLinks;
			alert("Maximum number of links exceeded.");
		}
		return result;
	},
	
	sortAlpha: function (anArray)
	{
		return anArray.sort( function(a,b)  { return (a.name.toLowerCase() < b.name.toLowerCase() ) ? -1 : 1; });
	},
	
	bindFunction: function(event, selector, functionRef, instance)
	{
		$(selector).bind(event, function() { functionRef.apply(instance);});
	}
	
});

// QuickLinksRenderer
// -----------------------------------------------
// Renders contents of Quicklinks menu. 

var QuickLinksRenderer = $.klass(QuickLinksPersistance,{

	// Constructor
	initialize: function($super, linksSelectId, linksDividerId, customizationURL, cookieDomain) 
	{
		$super(cookieDomain);
		this.selectElement = $(linksSelectId);
		this.listDividerElement = $(linksDividerId);
		this.customizeURL = customizationURL;
		this.addLinkDelegate = null;
		this.bindFunction('change', linksSelectId, this.quickLinksChanged, this);
		if(cookieDomain.charAt(0) == ".") {
			this.crossDomain = cookieDomain.substr(1);
		} else {
			this.crossDomain = cookieDomain;
		}
	},
	
	// onChanged handler for QuickLinks menu
	setAddLinkDeligate: function(delegate)
	{
		this.addLinkDelegate = delegate
	},
	
	// onChanged handler for QuickLinks menu
	quickLinksChanged: function()
	{	
		var linkURL = this.selectElement.options[this.selectElement.selectedIndex].value;
		if (linkURL ==">") { // Customize Quicklinks
			_gaq.push(['_trackPageview','QUICKLINKS' + linkURL]);
			top.window.location.href = this.customizeURL;
			return;
		}
		if (linkURL == "+") { // Add this page to quicklinks
			_gaq.push(['_trackPageview','QUICKLINKS' + linkURL]);
			this.addCurrentPage();
			return;
		}
		if (linkURL != ""){ // Other link
			_gaq.push(['_trackPageview','QUICKLINKS' + linkURL]);
			top.window.location.href = linkURL;
		} else { // Invalid link
			this.selectElement.selectedIndex=0;
		}
	},
  
	// Handler to add current page to the users custom list
	addCurrentPage: function()
	{
		document.domain = this.crossDomain;
		userTitle = prompt ("Save this page (" + top.window.location.href + ") as:",top.document.title);
		if (userTitle != null && userTitle != "")
		{
			newTitle = userTitle;
			this.quickLinkData.links.push({url: top.document.URL, name: newTitle});
			this.quickLinkData.links = this.sortAlpha(this.quickLinkData.links);
			
			this.saveQuickLinkData();
			this.populateQuicklinks();
				
			// sync Quick Links Manager if present
			if (this.addLinkDelegate)
			{
				this.addLinkDelegate.quickLinkData.links = jQuery.makeArray(this.quickLinkData.links);
				this.addLinkDelegate.initUI();
			}

		}

		// reset menu
		this.selectElement.selectedIndex=0;
		return false;
	},
	
	// append custom links to the select list
	populateQuicklinks: function()
	{	
		qlinkData = this.getQuickLinkData();
		
		// remove all subsequent siblings after the divider element
		this.listDividerElement.nextAll().remove();
		
		selElement = this.selectElement;
		
		if (qlinkData.links.length > 0 )
		{
			// append custom links
			jQuery.each(qlinkData.links, function(i,link){
				$(selElement).append('<option value="'+link.url+'">'+link.name+'</option>');
		
			});
			// append divider and Add This Page option
			$(selElement).append('<option value="+">- - - - - - - - - -</option>');	
		}
		
		$(selElement).append('<option value="+">+ Add This Page</option>');
		
		$(selElement).append('<option value="+">- - - - - - - - - -</option>');
		$(selElement).append('<option value=">">&gt; Customize This List</option>');
	} 
	
});

var quickLinks = null;

function initQuickLinks()
{
	
	$.each($(".UCFHeaderSearchText"), function(index, aInput) {
		 aInput.value=aInput.title;
		 aInput.style.color="#999"; 
	});
	
//	quickLinks = new QuickLinksRenderer("#UCFHeaderLinks", "#UCFHeaderLinksStaticDivider", 
// "http://www.ucf.edu/quicklinks/customizer.html",".ucf.edu");
	quickLinks = new QuickLinksRenderer("#UCFHeaderLinks", "#UCFHBHeaderLinks", "http://www.ucf.edu/quicklinks/customizer.html",
"cdws.devel");
	quickLinks.populateQuicklinks();
	return false;
}


