# MARAPI THEME STRUCTURE
>_!!! JANGAN DI EDIT_
# ini adalah penjelasan tentang bagaimana sistem tema bekerja

di sini root adalah ***/public/theme/*** dimana semua tema akan di letakan
semua folder yang berisikan ***.theme*** di dalam root akan di anggap sebagai tema

## .theme
***.theme*** sendiri memiliki strukture sebagai berikut

> WAJIB
1. main
2. content

> TIDAK WAJIB
1. nav-fragment
2. menu-fragment

### CONTOH
_tree theme_

      dir |- .teme
          |- index.html
          |- kontent.html

_file .theme_
      
      @name = default theme
      @description = descripsi tentang tema
      @author = Jhon smith
      
      #index = index.html
      #content = kontent.html
