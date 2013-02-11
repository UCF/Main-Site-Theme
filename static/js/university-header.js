/**** Insert Bar markup and CSS resources ***/
			
	function GlobalUCFHeaderInit(){
		
		// Insert CSS link as first  item in head of document
		/*headerCSS = document.createElement("link")
		headerCSS.setAttribute("href","https://universityheader.ucf.edu/bar/css/bar.css");
		headerCSS.setAttribute("rel","stylesheet");
		headerCSS.setAttribute("type","text/css");

		headEl = document.getElementsByTagName("head")[0];
		if (headEl.childNodes.length > 0 ) {
			headEl.insertBefore(headerCSS,headEl.firstChild);
		} else {
			headEl.appendChild(headerCSS);
		}*/
		
		// find and create insertion point for header
		// first item in the body
		headerDiv = document.createElement("div");
		headerDiv.id = "UCFHBHeader";
		bodyEl = document.getElementsByTagName("body")[0];
		
		if (bodyEl.childNodes.length > 0 ) {
			bodyEl.insertBefore(headerDiv,bodyEl.firstChild);
		} else {
			bodyEl.appendChild(headerDiv);
		}
		
		// create contents
		var elementContent='<img class="print-only" src="' + PRINT_HEADER_IMG + '" style="width: 100%;" />'+    	
		'		<div class="UCFHBWrapper">'+
		'			<div id="UCFtitle">'+
		'				<a href="http:\/\/www.ucf.edu\/">'+
		'				<span class="UCFHBText">University of Central Florida<\/span>'+
		'				<\/a>'+
		'			<\/div>'+
		'			<label for="UCFHeaderLinks">University Links<\/label>'+
		'			<label for="q">Search UCF<\/label>'+
		'			<div id="UCFHBSearch_and_links">'+
		'				'+
		'				<form id="UCFHBUni_links" action="" target="_top">'+
		'					<fieldset>'+
		'					   <select name="UniversityLinks" id="UCFHBHeaderLinks" onchange="quickLinks.quickLinksChanged()">'+
		'						<option value="">Quicklinks:<\/option>'+
		'						'+
		'	<option value="">- - - - - - - - - -<\/option>'+
		'					<\/select>'+
		'					<\/fieldset>'+
		'				<\/form>'+
		'				<div>'+
		'					<a id="UCFHBMy_ucf" href="http:\/\/my.ucf.edu\/">'+
		'						<span class="text">myUCF<\/span>'+
		'					<\/a>'+
		'				<\/div>'+
		'				'+
		'				<form id="UCFHBSearch_ucf" method="get" action="http:\/\/google.cc.ucf.edu\/search" target="_top">'+
		'					<fieldset> '+
		'						<input type="hidden" name="output" value="xml_no_dtd"\/>'+
		'						<input type="hidden" name="proxystylesheet" value="UCF_Main"\/>'+
		'						<input type="hidden" name="client" value="UCF_Main"\/>'+
		'						<input type="hidden" name="site" value="UCF_Main"\/>'+
		'						<input class="text" type="text" name="q" id="q" value="Search UCF" title="Search UCF" onfocus="clearDefault(this);" onblur="clearDefault(this);" \/> '+
		'						<input id="UCFHBsubmit" type="submit" value="" \/>'+
		'					<\/fieldset>'+
		'				<\/form>'+
		'				<div id="UCFHBClearBoth"><\/div>'+
		'			<\/div>'+
		'		<\/div>';

		// fill element with contents
		headerDiv.innerHTML = elementContent;

		
		quickLinks = new QuickLinksRenderer();
		quickLinks.init();
		quickLinks.populateQuickLinks();
		
	}

	// clear default contents of text fields on first click
	function clearDefault(element) 
	{
		if(element.value==element.title) {
		   element.value="";
		   element.style.color="#000";
		   return;
		}
		
		if(element.value=="") {
			
			if (element.title != "") {
				element.value = element.title;
				element.style.color="#999";
			} 
		}	
	}

	
	/*****  Cross platform DOM Ready Event ****/
	
	(function(i) {
  var u = navigator.userAgent.toLowerCase();
  var ie = /*@cc_on!@*/false;
  if (/webkit/.test(u)) {
    // safari
    timeout = setTimeout(function(){
			if ( document.readyState == "loaded" || 
				document.readyState == "complete" ) {
				i();
			} else {
			  setTimeout(arguments.callee,10);
			}
		}, 10); 
  } else if ((/mozilla/.test(u) && !/(compatible)/.test(u)) ||
             (/opera/.test(u))) {
    // opera/moz
    document.addEventListener("DOMContentLoaded",i,false);
  } else if (ie) {
    // IE
    (function (){ 
      var tempNode = document.createElement('document:ready'); 
      try {
        tempNode.doScroll('left'); 
        i(); 
        tempNode = null; 
      } catch(e) { 
        setTimeout(arguments.callee, 0); 
      } 
    })();
  } else {
    window.onload = i;
  }
})(GlobalUCFHeaderInit);

	/**** JSON Parse and Encode ****/
	
	/*
		http://www.JSON.org/json2.js
		2008-07-15
	
		Public Domain.
	
		NO WARRANTY EXPRESSED OR IMPLIED. USE AT YOUR OWN RISK.
	
		See http://www.JSON.org/js.html
	
	*/
	
	if ((!this.JSON) && (!Object.toJSON)) {
	
	// Create a JSON object only if one does not already exist. We create the
	// object in a closure to avoid creating global variables.
	
		JSON = function () {
	
			function f(n) {
				// Format integers to have at least two digits.
				return n < 10 ? '0' + n : n;
			}
	
			Date.prototype.toJSON = function (key) {
	
				return this.getUTCFullYear()   + '-' +
					 f(this.getUTCMonth() + 1) + '-' +
					 f(this.getUTCDate())      + 'T' +
					 f(this.getUTCHours())     + ':' +
					 f(this.getUTCMinutes())   + ':' +
					 f(this.getUTCSeconds())   + 'Z';
			};
	
			String.prototype.toJSON =
			Number.prototype.toJSON =
			Boolean.prototype.toJSON = function (key) {
				return this.valueOf();
			};
	
			var cx = /[\u0000\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,
				escapeable = /[\\\"\x00-\x1f\x7f-\x9f\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,
				gap,
				indent,
				meta = {    // table of character substitutions
					'\b': '\\b',
					'\t': '\\t',
					'\n': '\\n',
					'\f': '\\f',
					'\r': '\\r',
					'"' : '\\"',
					'\\': '\\\\'
				},
				rep;
	
	
			function quote(string) {
	
				escapeable.lastIndex = 0;
				return escapeable.test(string) ?
					'"' + string.replace(escapeable, function (a) {
						var c = meta[a];
						if (typeof c === 'string') {
							return c;
						}
						return '\\u' + ('0000' +
								(+(a.charCodeAt(0))).toString(16)).slice(-4);
					}) + '"' :
					'"' + string + '"';
			}
	
	
			function str(key, holder) {
	
				var i,          // The loop counter.
					k,          // The member key.
					v,          // The member value.
					length,
					mind = gap,
					partial,
					value = holder[key];
	
				if (value && typeof value === 'object' &&
						typeof value.toJSON === 'function') {
					value = value.toJSON(key);
				}
	
				if (typeof rep === 'function') {
					value = rep.call(holder, key, value);
				}
	
				switch (typeof value) {
				case 'string':
					return quote(value);
	
				case 'number':
	
					return isFinite(value) ? String(value) : 'null';
	
				case 'boolean':
				case 'null':
	
					return String(value);
	
				case 'object':
	
					if (!value) {
						return 'null';
					}
	
					gap += indent;
					partial = [];
	
					if (typeof value.length === 'number' &&
							!(value.propertyIsEnumerable('length'))) {
	
						length = value.length;
						for (i = 0; i < length; i += 1) {
							partial[i] = str(i, value) || 'null';
						}
	
						v = partial.length === 0 ? '[]' :
							gap ? '[\n' + gap +
									partial.join(',\n' + gap) + '\n' +
										mind + ']' :
								  '[' + partial.join(',') + ']';
						gap = mind;
						return v;
					}
	
					if (rep && typeof rep === 'object') {
						length = rep.length;
						for (i = 0; i < length; i += 1) {
							k = rep[i];
							if (typeof k === 'string') {
								v = str(k, value);
								if (v) {
									partial.push(quote(k) + (gap ? ': ' : ':') + v);
								}
							}
						}
					} else {
	
						for (k in value) {
							if (Object.hasOwnProperty.call(value, k)) {
								v = str(k, value);
								if (v) {
									partial.push(quote(k) + (gap ? ': ' : ':') + v);
								}
							}
						}
					}
	
					v = partial.length === 0 ? '{}' :
						gap ? '{\n' + gap + partial.join(',\n' + gap) + '\n' +
								mind + '}' : '{' + partial.join(',') + '}';
					gap = mind;
					return v;
				}
			}
	
	
			return {
				stringify: function (value, replacer, space) {
	
					var i;
					gap = '';
					indent = '';
	
	
					if (typeof space === 'number') {
						for (i = 0; i < space; i += 1) {
							indent += ' ';
						}
	
					} else if (typeof space === 'string') {
						indent = space;
					}
	
					rep = replacer;
					if (replacer && typeof replacer !== 'function' &&
							(typeof replacer !== 'object' ||
							 typeof replacer.length !== 'number')) {
						throw new Error('JSON.stringify');
					}
	
					return str('', {'': value});
				},
	
	
				parse: function (text, reviver) {
	
					var j;
	
					function walk(holder, key) {
	
						var k, v, value = holder[key];
						if (value && typeof value === 'object') {
							for (k in value) {
								if (Object.hasOwnProperty.call(value, k)) {
									v = walk(value, k);
									if (v !== undefined) {
										value[k] = v;
									} else {
										delete value[k];
									}
								}
							}
						}
						return reviver.call(holder, key, value);
					}
	
					cx.lastIndex = 0;
					if (cx.test(text)) {
						text = text.replace(cx, function (a) {
							return '\\u' + ('0000' +
									(+(a.charCodeAt(0))).toString(16)).slice(-4);
						});
					}
	
	
					if (/^[\],:{}\s]*$/.
	test(text.replace(/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g, '@').
	replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').
	replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {
	
	
						j = eval('(' + text + ')');
	
	
						return typeof reviver === 'function' ?
							walk({'': j}, '') : j;
					}
	
					throw new SyntaxError('JSON.parse');
				}
			};
		}();
	}

				
	// QuickLinksRenderer
	// -----------------------------------------------
	// Renders contents of Quicklinks menu. 
	//
	// Designed for use on external sites
	//
	// Configuration options at bottom of class definition
	
	function QuickLinksRenderer() {
				
		
		this.init = function() { 
			//Customization URL
			this.customizationURL = "http://www.ucf.edu/quicklinks/customizer.html";
			this.selectEl = document.getElementById("UCFHBHeaderLinks");
			
			// cookie jar options
			this.options = {
				cookie: {
					expires: 630720,
					path: "/",
					domain: ".ucf.edu"
				},
				cacheCookie:    true,
				cookiePrefix:   'jqCookieJar_',
				debug:          false
			};
			this.name = "quicklinks";
			this.cookieName = this.options.cookiePrefix + this.name;
			this.jarRoot = {quickLinkData:{links:[]}};
			this.links = new Array();
		}
		
		this.quickLinksChanged = function(selectElement){
			
			var linkURL = this.selectEl.options[this.selectEl.selectedIndex].value;
			if (linkURL ==">") {document.location = this.customizationURL;return;}
			if (linkURL == "+") {this.addCurrentPage();return;}
			if (linkURL != ""){document.location = linkURL;}
			else { selectElement.selectedIndex=0;}

		};
		
		
		/* Cookie methods based on jQuery cookie plugin
 		*
 		* Copyright (c) 2006 Klaus Hartl (stilbuero.de)
 		* Dual licensed under the MIT and GPL licenses:
 		* http://www.opensource.org/licenses/mit-license.php
 		* http://www.gnu.org/licenses/gpl.html
		*/
		
		this.cookie = function(name, value, options) {
			if (typeof value != 'undefined') { // name and value given, set cookie
				options = options || {};
				if (value === null) {
					value = '';
					options.expires = -1;
				}
				var expires = '';
				if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
					var date;
					if (typeof options.expires == 'number') {
						date = new Date();
						date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
					} else {
						date = options.expires;
					}
					expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
				}
				var path = options.path ? '; path=' + options.path : '';
				var domain = options.domain ? '; domain=' + options.domain : '';
				var secure = options.secure ? '; secure' : '';
				document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
			} else { // only name given, get cookie
				var cookieValue = null;
				if (document.cookie && document.cookie != '') {
					var cookies = document.cookie.split(';');
					for (var i = 0; i < cookies.length; i++) {
						var cookie = (cookies[i] || "").replace( /^\s+|\s+$/g, "" );
						// Does this cookie string begin with the name we want?
						if (cookie.substring(0, name.length + 1) == (name + '=')) {
							cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
							break;
						}
					}
				}
				return cookieValue;
			}
		};
		
		
		this.sortAlpha = function (anArray)
		{
			if (anArray.sort) {
				return anArray.sort( function(a,b)  { return (a.name.toLowerCase() < b.name.toLowerCase() ) ? -1 : 1; });
			} else {
				return anArray;
			}
		},
	
		
		this.loadQuickLinksData = function() {
		
			jsonString = this.cookie(this.cookieName);
			
			if (typeof jsonString == 'string') {
				// If using Prototype, we must use it's JSON implementation
				if (Object.toJSON) {
					this.jarRoot = jsonString.evalJSON();		
				} else {
					this.jarRoot = JSON.parse(jsonString, true);
				}
			} 
						
			if (this.jarRoot.quickLinkData && this.jarRoot.quickLinkData.links) {
				this.links = this.sortAlpha(this.jarRoot.quickLinkData.links);
			} else {
				this.jarRoot = {quickLinkData:{links:[]}};
				this.links = new Array();
			}
		};
		
		this.addCurrentPage = function() {
		
			userTitle = prompt ("Save this page as:",document.title);
			if (userTitle != null && userTitle != "")
			{				
				newTitle = userTitle;
				
				oldLinks = this.links.concat();
				
				this.links.push({url: document.URL, name: newTitle});
				this.links = this.sortAlpha(this.links);
				
				if (this.saveQuickLinksData()) {				
					this.populateQuickLinks();
				} else {
					alert("Maximum number of links exceeded.");
					this.links = oldLinks;
				}
			}
	
			// reset menu
			this.selectEl.selectedIndex=0;
			return false;
		},

		
		this.populateQuickLinks = function () {	
		
			this.loadQuickLinksData();
			
			selectEl = this.selectEl;
			
			selectEl.options.length = 2;
						
			selectEl.options.add(new Option("Libraries", "http://library.ucf.edu"));
			selectEl.options.add(new Option("Directories (A-Z Index)", "http://www.ucf.edu/directories/"));
			selectEl.options.add(new Option("Campus Map", "http://map.ucf.edu"));
			selectEl.options.add(new Option("Giving to UCF", "http://ucffoundation.org/"));
			selectEl.options.add(new Option("Ask UCF", "http://ask.ucf.edu"));
			selectEl.options.add(new Option("Financial Aid", "http://finaid.ucf.edu/"));
			selectEl.options.add(new Option("UCF Today", "http://today.ucf.edu/"));
			selectEl.options.add(new Option("Knight's Email", "https://www.secure.net.ucf.edu/knightsmail/"));
			selectEl.options.add(new Option("Events at UCF", "http://events.ucf.edu/"));
			selectEl.options.add(new Option("UCF 50th Anniversary", "http://www.ucf.edu/50/"));
			selectEl.options.add(new Option("- - - - - - - - - -", ""));
			/*selectEl.options.add(new Option("Academics", "http://www.ucf.edu/academics"));
			selectEl.options.add(new Option("Admissions", "http://www.ucf.edu/admissions"));
			selectEl.options.add(new Option("Research", "http://www.ucf.edu/research/"));
			selectEl.options.add(new Option("Locations", "http://www.ucf.edu/locations/"));
			selectEl.options.add(new Option("Campus Life", "http://www.ucf.edu/campus_life/"));
			selectEl.options.add(new Option("Alumni & Friends", "http://www.ucf.edu/alumni_and_friends/"));
			selectEl.options.add(new Option("Athletics", "http://www.ucf.edu/athletics/"));
			selectEl.options.add(new Option("- - - - - - - - - -", ""));*/
								
			if (this.links.length > 0 )
			{
				// append user links
				for (var i = 0; i < this.links.length; i++) 
  				{
     				selectEl.options.add(new Option(this.links[i].name,this.links[i].url));
				}
				
				// append divider and Add This Page option
				selectEl.options.add(new Option("- - - - - - - - - -", ""));
			}
			
			selectEl.options.add(new Option("+ Add This Page", "+"));
			selectEl.options.add(new Option("- - - - - - - - - -", ""));
			selectEl.options.add(new Option("> Customize This List", ">"));
		}		
		
		this.saveQuickLinksData = function(){
		
			this.jarRoot.quickLinkData.links = this.links;
			
			newJSONString = '';
			
			//if using prototype, we must use it's JSON implementation 
			if(Object.toJSON){
				newJSONString = Object.toJSON(this.jarRoot);				
			} else {
				newJSONString = JSON.stringify(this.jarRoot);
			} 
			
			if(newJSONString.length >4000) { return false; }
			
			this.cookie(this.cookieName, newJSONString, this.options.cookie);
			return true;

		};
		
		
	};	
	
	// clear default contents of text fields on first click
	function clearDefault(element) 
	{
	
		if(element.value==element.title) {
		   element.value="";
		   element.style.color="#000";
		   return;
		}
		
		if(element.value=="") {
			
			if (element.title != "") {
				element.value = element.title;
				element.style.color="#999";
			} 
		}	
	}


