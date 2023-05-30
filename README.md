# Citation Shortcode
Creates Wordpress non-theme specific citation shortcodes for adhd research micro-site
 > [research_citation style="" pubtype="" authors="" year="" title="" volume="" issue="" journal="" shortjournal="" startpage="" endpage="" articlenum="" doi=""]

## Microformat
 Uses h-cite microformat markup. See: [h-cite](https://microformats.org/wiki/h-cite) and: [h-card](https://microformats.org/wiki/h-card)
 
## Styles
Currently just APA 7.
 See: https://owl.purdue.edu/owl/research_and_citation/apa_style/apa_formatting_and_style_guide/reference_list_basic_rules.html

Note on number of authors in APA 7 formatting:
> Give the last name and first/middle initials for all authors of a particular work up to and including 20 authors (this is a new rule, as APA 6 only required the first six authors). Separate each author’s initials from the next  author in the list with a comma. Use an ampersand (&) before the last author’s name. If there are 21 or more authors, use an ellipsis (but no ampersand) after the 19th author, and then add the final author’s name.

## Usage
 e.g. using Formidable Forms as input:
 
 ### Shortcode
 > [research_citation style="APA" pubtype="journal" authors="[foreach 104][98] [99] [100],[/foreach]" year="[111]" title="[102]" volume="[112]" issue="[113]" journal="[109]" shortjournal="[110]" startpage="[114]" endpage="[115]" articlenum="" doi="[117]"]

### Generated Markup
```
<blockquote class="cite_apa h-cite">
    <abbr rel="author" class="p-author h-card" title="Yasser Amer">Amer, Y.S.</abbr>,
    <abbr rel="author" class="p-author h-card" title="Haya Al-Joudi">Al-Joudi, H.F.</abbr>,
    <abbr rel="author" class="p-author h-card" title="Jeremy Varnham">Varnham, J.L.</abbr>,
    <abbr rel="author" class="p-author h-card" title="Fahad Bashiri">Bashiri, F.A.</abbr>,
    <abbr rel="author" class="p-author h-card" title="Muddathir Hamad">Hamad, M.H.</abbr>,
    <abbr rel="author" class="p-author h-card" title="Saleh Al-Salehi">Al-Salehi, S.M.</abbr>
    <abbr rel="author" class="p-author h-card" title="Hadeel Daghash">Daghash, H.F.</abbr>,
    &amp; <abbr rel="author" class="p-author h-card" title="Turki Albatti">Albatti, T.H.</abbr>
    (<time class="dt-published">2019</time>).
    <cite class="p-name noitalics">Appraisal of clinical practice guidelines for the management of attention deficit hyperactivity disorder (ADHD) using the AGREE II Instrument: A systematic review</cite>.
    <i><abbr title="PLoS ONE">PLoS ONE</abbr></i>, 14(7),
    doi: <a class="u-uid" href="https://doi.org/10.1371/journal.pone.0219239" target="_blank">10.1371/journal.pone.0219239</a>
</blockquote>
```
### Generated Output
<blockquote class="cite_apa h-cite"><abbr rel="author" class="p-author h-card" title="Yasser Amer">Amer, Y.S.</abbr>, <abbr rel="author" class="p-author h-card" title="Haya Al-Joudi">Al-Joudi, H.F.</abbr>, <abbr rel="author" class="p-author h-card" title="Jeremy Varnham">Varnham, J.L.</abbr>, <abbr rel="author" class="p-author h-card" title="Fahad Bashiri">Bashiri, F.A.</abbr>, <abbr rel="author" class="p-author h-card" title="Muddathir Hamad">Hamad, M.H.</abbr>, <abbr rel="author" class="p-author h-card" title="Saleh Al-Salehi">Al-Salehi, S.M.</abbr>, <abbr rel="author" class="p-author h-card" title="Hadeel Daghash">Daghash, H.F.</abbr>, &amp; <abbr rel="author" class="p-author h-card" title="Turki Albatti">Albatti, T.H.</abbr>  (<time class="dt-published">2019</time>). <cite class="p-name noitalics">Appraisal of clinical practice guidelines for the management of attention deficit hyperactivity disorder (ADHD) using the AGREE II Instrument: A systematic review</cite>. <i><abbr title="PLoS ONE">PLoS ONE</abbr></i>, 14(7), doi: <a class="u-uid" href="https://doi.org/10.1371/journal.pone.0219239" target="_blank">10.1371/journal.pone.0219239</a></blockquote>

### Live Example
See: https://res.adhd.org.sa/en/lib/study/e93ob/
