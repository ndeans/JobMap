# JobMap
JobMap Project 

This is a project that I featured in my tech blog http://www.deans.us/infoscope/projects_main/project-page-job-map

Basically, it's a single-page web application that runs on the browser and displays the estimated locations of potential jobs that I have been tracking on a CRM to help with visualizing potential commutes and things like that.

The CRM I am using is SugarCRM, which runs on a LAMP stack. The mapping software is Google Maps and I use Javascript to glue it all together. This is all contained in two files... An HTML file containing the HTML, the CSS AND the Javascript to support the single-page app and a PHP file for customizing the backend schema.

Note: The GitHub linguist initially reporting this as an HTML project, because the HTML file is the larger of the two and it has an HTML extension. I added a .gitattributes file which tells the linguist which files to ignore (not ignore from source control, but from the linguistic assessment) I added the HTML file to this .gitattributes file so now it looks for the next largest file, which has a PHP extension. I guess this is a good argument for putting the Javascript in a separate file.






