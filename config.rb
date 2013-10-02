# This file controls basic configuration of Foundation. It lets Compass know where your uncompiled files are and where
# they should be compiled to.

require 'zurb-foundation'

#
#
# Require any additional compass plugins here.
#
#

# Set this to the root of your project when deployed:
http_path = "/"

# This is where your UNcompiled SASS is located (system path):
sass_dir = "_compass/sass"

# This is where the compiled CSS will be saved (system path):
css_dir = "assets/css"

# This is the system path where compass can find your images:
images_dir = "assets/images"

# This is the path the compiled CSS will prepend to image-url() links (note: must use image-url() not url() ):
http_images_path = "../images/"

# This is the system path where compass can find your UNcompiled js:
javascripts_dir = "_compass/javascripts"

# You can select your preferred output style here (can be overridden via the command line):
output_style = :nested
# :nested, :expanded, :compact, or :compressed

# To enable relative paths to assets via compass helper functions. Uncomment:
# relative_assets = true

# To disable debugging comments that display the original location of your selectors. Uncomment:
line_comments = false


# If you prefer the indented syntax, you might want to regenerate this
# project again passing --syntax sass, or you can uncomment this:
# preferred_syntax = :sass
# and then run:
# sass-convert -R --from scss --to sass sass scss && rm -rf sass && mv scss sass