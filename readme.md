[![Magento 2](https://img.shields.io/badge/Magento2-yes-green.svg)](https://github.com/mSengera/Magento-2-CSV-to-301-Redirect-Extension)

# [Magento 2] Sengera/DreiNullEins
301 redirects via CSV

A extension to declare a CSV File with certain redirect pairs (New Url and Old Url).
If Magento 2 try to force an 404 error this extension check first: "Contains the CSV the requested URL?"
If the CSV contain the requested URL the extension will redirect to the new url and send a 301 to the browser.

With this extension you have a chance to minimize 404 errors on your page. 
You will often need this for SEO purposes. 

Installation
------------

1. Copy the whole content of this module in your Magento installation directory.
2. Run "bin/magento setup:upgrade"
3. Depending on your Workspace: Run setup:di:compile and redeploy static-content if needed
4. Clear cache (Console "bin/magento c:c" or via Backend)
5. Customize the var/dreinulleins.csv to fit your needs. Every row one pair of URLs.
6. Rewrite templates and customize them.
7. Test extension and be happy.

Best regards and happy coding!