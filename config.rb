# Require any additional compass plugins here.
add_import_path "_foundation/bower_components/foundation/scss"

# Set this to the root of your project when deployed:
http_path = "/"

# Where should CSS compile to?
css_dir = "assets/css"

# Where Compass can find the uncompiled SASS
sass_dir = "_foundation/scss"

# Path where Compass can find your images
images_dir = "assets/images"

# Path to uncompiled javascripts (note: ZF5 uses bower, so this is somewhat inconsequential)
javascripts_dir = "_foundation/js"

# Compass will prepend this string to image-url() properties when it compiles your SASS
http_images_path = "../images/"

# You can select your preferred output style here (can be overridden via the command line):
# output_style = :expanded or :nested or :compact or :compressed
output_style = :nested

# To enable relative paths to assets via compass helper functions. Uncomment:
# relative_assets = true

# To disable debugging comments that display the original location of your selectors. Uncomment:
# line_comments = false


# If you prefer the indented syntax, you might want to regenerate this
# project again passing --syntax sass, or you can uncomment this:
# preferred_syntax = :sass
# and then run:
# sass-convert -R --from scss --to sass sass scss && rm -rf sass && mv scss sass
