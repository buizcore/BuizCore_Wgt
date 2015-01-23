#!/bin/bash

#cd "./css"

#for i in `find ./css/ -name *.less`
#do

#  sDir=`dirname $i`
#  sFile=`basename $i .less`
  
#  echo "compile ${sDir}/${sFile}.less";
#  lessc "${sDir}/${sFile}.less" > "${sDir}/${sFile}.css"

#done

lessc "./themes/classic/theme_ria.less" > "./themes/classic/theme_ria.css"
lessc "./themes/classic/theme_web.less" > "./themes/classic/theme_web.css"

lessc "./css/wgt2/layout.less" > "./css/wgt2/layout.css"
lessc "./css/wgt2/base.less" > "./css/wgt2/base.css"
lessc "./css/bootstrap.less" > "./css/bootstrap.css"
lessc "./css/fontawesome.less" > "./css/fontawesome.css"
lessc "./css/ria.less" > "./css/ria.css"
lessc "./css/web.less" > "./css/web.css"

#lessc "./web/less/main.less" > "./web/css/style.css"
#lessc "./web/less/file-web.less" > "./web/css/web.css"
#lessc "./web/less/file-web.admin.less" > "./web/css/web.admin.css"

#for i in `find ./themes/ -name *.less`
#do

#  sDir=`dirname $i`
#  sFile=`basename $i .less`
  
#  echo "compile ${sDir}/${sFile}.less";
#  lessc "${sDir}/${sFile}.less" > "${sDir}/${sFile}.css"

#done

echo Done
