#!/bin/bash.sh

#cd "./css"

#for i in `find ./css/ -name *.less`
#do

#  sDir=`dirname $i`
#  sFile=`basename $i .less`
  
#  echo "compile ${sDir}/${sFile}.less";
#  lessc "${sDir}/${sFile}.less" > "${sDir}/${sFile}.css"

#done

php ../WebFrap_Vendor/vendor/lessphp/plessc "./themes/classic/theme_ria.less" > "./themes/classic/theme_ria.css"
#php ../WebFrap_Vendor/vendor/lessphp/plessc "./themes/classic/theme_ria_new.less" > "./themes/classic/theme_ria_new.css"

#php ../WebFrap_Vendor/vendor/lessphp/plessc "./css/wgt2/layout.less" > "./css/wgt2/layout.css"
#php ../WebFrap_Vendor/vendor/lessphp/plessc "./css/wgt2/base.less" > "./css/wgt2/base.css"
#php ../WebFrap_Vendor/vendor/lessphp/plessc "./css/bootstrap.less" > "./css/bootstrap.css"
#php ../WebFrap_Vendor/vendor/lessphp/plessc "./css/fontawesome.less" > "./css/fontawesome.css"
#php ../WebFrap_Vendor/vendor/lessphp/plessc "./css/ria.less" > "./css/ria.css"
#php ../WebFrap_Vendor/vendor/lessphp/plessc "./css/ria_new.less" > "./css/ria_new.css"
#php ../WebFrap_Vendor/vendor/lessphp/plessc "./css/ria_old.less" > "./css/ria_old.css"
#php ../WebFrap_Vendor/vendor/lessphp/plessc "./css/web.less" > "./css/web.css"

#for i in `find ./themes/ -name *.less`
#do

#  sDir=`dirname $i`
#  sFile=`basename $i .less`
  
#  echo "compile ${sDir}/${sFile}.less";
#  lessc "${sDir}/${sFile}.less" > "${sDir}/${sFile}.css"

#done

echo Done
