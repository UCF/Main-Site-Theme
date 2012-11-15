/* QuickLinks customization UI classes and onDomLoad registration */

// Requires QuickLinksPersistance defined in quick_links.js 

// QuickLinksManager
var QuickLinksManager = $.klass(QuickLinksPersistance,{

	// Constructor
	initialize: function($super, sourceId, destinationId, addId, removeId, clearId, cookieDomain) 
	{
		$super(cookieDomain);
		this.sourceEl = $(sourceId)[0];
		this.destEl = $(destinationId)[0];	
		this.destId = destinationId;
		this.sourceId = sourceId;
		this.sourceLinks = null;
		
		this.bindFunction('click', addId, this.addSelected, this);
		this.bindFunction('click', removeId, this.removeSelected, this);
		this.bindFunction('click', clearId, this.removeAll, this);
		
	},

	// Add link from source column
	addSelected: function()
	{	
		this.swapOptions(this.sourceEl, this.destEl);
		this.rebuildUserLinks();
		this.saveQuickLinkData();
		this.syncQuickLinks();		
	},
	
	// 
	rebuildUserLinks: function()
	{	
		qLinks = new Array();
		
		jQuery.each(this.destEl.options, function(i,o)
		{ 
			qLinks[i]={name: o.text, url: o.value};
		});
		
		this.quickLinkData.links = qLinks;
	},
		
	// Remove link from destination column
	removeSelected: function()
	{
		this.swapOptions(this.destEl, this.sourceEl);
		this.rebuildUserLinks();	
		this.saveQuickLinkData();
		this.syncQuickLinks();
	},
	
	//Sync Quicklinks menu
	syncQuickLinks: function()
	{
		quickLinks.quickLinkData.links = jQuery.makeArray(this.quickLinkData.links);
		quickLinks.populateQuicklinks();	
	},

	swapOptions: function(sourceEl, destEl) 
	{
  		var selectOptions = sourceEl.getElementsByTagName('option');
  		
		for (var i = 0; i < selectOptions.length; i++) 
		{
			var opt = selectOptions[i];
			if (opt.selected) 
			{
				sourceEl.removeChild(opt);
				destEl.appendChild(opt);
				i--;
			}
		}
		
		// work around a DOM modification bug in IE 6
		if(window.XMLHttpRequest) {this.sortSelectEl(destEl);}
			
	},
	
	sortSelectEl: function(selectEl) 
	{
		// build a list of items from select list
		tempOptions = new Array(selectEl.options.length);
		jQuery.each(selectEl.options, function(index,sOption)
		{
			tempOptions[index] = new Object();
			tempOptions[index].text = sOption.text;
			tempOptions[index].value = sOption.value;
		});
		
		tempOptions.sort( function(a,b) { 
		
			result = (a.text.toLowerCase() < b.text.toLowerCase() ) ? -1 : 1; 
			return result;
		});
		
		jQuery.each(tempOptions, function(index,dOption)
		{
			selectEl.options[index].text = dOption.text;
			selectEl.options[index].value = dOption.value;
		});
	
	},
	
	// Clear all custom links
	removeAll: function()
	{	
		var selectOptions = this.destEl.getElementsByTagName('option');
  		for (var i = 0; i < selectOptions.length; i++) 
  		{
     		var opt = selectOptions[i].selected = true;
		}
		this.removeSelected();
	},
	
	// Populate the UI with avaialble links and current links
	initUI: function(doIt)
	{	
			// filter out links already selected
			allLinks = jQuery.makeArray(this.getAvailableLinks().links);
			userLinks = jQuery.makeArray(this.getQuickLinkData().links);
		
			displayLinks = jQuery.grep(allLinks, function (sLink){
			
					for (var u = 0; u < userLinks.length; u++)
					{
						var uLink = userLinks[u];
						if (uLink.url == sLink.url)
						{
							return false; 						
						}
					}	
					return true;
			});
								
			// source links
			this.populateSelectLinks(displayLinks,this.sourceEl);
			
			// current links
			this.populateSelectLinks(this.getQuickLinkData().links,this.destEl);
	},
	
	// populate select with list
	populateSelectLinks: function(data, selectEl)
	{			
		
		selectEl.length = 0;
		if (data.length > 0)
		{
			jQuery.each(data, function(index,link){
				selectEl.options[index] = new Option(link.name, link.url);

			});
		}
	},

	// Returns array of available links
	getAvailableLinks: function()
	{	
		if (this.sourceLinks==null)
		{
			// extract from soure select list
			linkElements = $("#"+this.sourceEl.id+" option");
			parsedLinks = {links: []};
			
			jQuery.each(linkElements, function(index,sLink)
			{
				parsedLinks.links[index] = {name: sLink.text, url: sLink.value };
			});
			
			this.sourceLinks = parsedLinks;
			this.sourceLinks.links = this.sortAlpha(this.sourceLinks.links);
		}
					
		return this.sourceLinks;
	},
	
	// Update the customization UI
	updateUI: function()
	{	
		// nada
	}

});


var quickLinksMgr = null;

function initQuickLinksManager()
{
	quickLinksMgr = new QuickLinksManager("#sourceLinks", "#destinationLinks", "#addLinks", "#removeLinks", "#clearLinks", ".ucf.edu");
	quickLinks.setAddLinkDeligate(quickLinksMgr);
	quickLinksMgr.initUI();
	return false;
}


