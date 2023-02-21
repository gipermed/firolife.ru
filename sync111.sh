#!/bin/sh

rsync --progress -rvht --delete-after --exclude-from='sync_exclude' dma880ys_ihome@dma880ys.beget.tech:~/gipermed.palladiumlab.site/public_html/* ./
rsync --progress -rvht --delete-after --exclude-from='sync_exclude' dma880ys_ihome@dma880ys.beget.tech:~/gipermed.palladiumlab.site/public_html/.[^.]* ./
#rsync --progress -rvht --delete-after --exclude-from='sync_exclude' dma880ys_ihome@dma880ys.beget.tech:~/gipermed.palladiumlab.site/public_html/.git/* ./.git/