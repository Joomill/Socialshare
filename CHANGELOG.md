# Changelog

All notable changes to the Extension are documented in this file.

## Unreleased

- Add: Custom CSS field in the layout options, injected into the frontend page head through the WebAssetManager when the share buttons render
- Add: faster plugin loading on Joomla 6.1+ with PHP 8.4 or higher
- Add: Help button in plugin settings now links directly to the documentation page
- Fix: sharing buttons now work correctly in category and featured article views
- Fix: security improvements to how output is rendered in the templates
- Fix: improved compatibility with Joomla 5 and 6 internals
- Changed: minimum required Joomla version is now 5.0
- Changed: Update Mastodon sharing URL
- Fix: Avoid PHP warning by handling null category descriptions


## TODO
- Check bc for Joomla 7 release: https://github.com/joomla/Manual/blob/main/updates/64-70/removed-backward-incompatibility.md
- Check joomla installer script volgens: C:\Obsidian\Joomill-Vault\Joomill\30-snippets\joomla-installer-script.md
- 
Claude finished the response
400 Bad Request https://web.whatsapp.com/send?text=Cultuurcafé+in+Historiehuis+https%<No Text> 400 Bad Request https://web.whatsapp.com/send?text=De+Tweede+Wereldoorlog+1939-19<No Text> 400 Bad Request https://web.whatsapp.com/send?text=1+januari+1926+watersnood+in+Me<No Text> 400 Bad Request https://web.whatsapp.com/send?text=Romeinen+maakten+al+duurzaam+<No Text> 400 Bad Request https://web.whatsapp.com/send?text=100+jaar+vrouwen+in+de+Nederlan<No Text> 400 Bad Request https://web.whatsapp.com/send?text=Bourgondische+invloed+op+Limbur<No Text> 400 Bad Request https://web.whatsapp.com/send?text=Dagboek+van+een+mijnwerker+–+S<No Text> 400 Bad Request https://web.whatsapp.com/send?text=Promotievideo+Monumentendag+2<No Text> 400 Bad Request https://web.whatsapp.com/send?text=Kinderpret+van+vroeger+https%3A<No Text> 400 Bad Request https://web.whatsapp.com/send?text=Nieuws+van+RivierPark+Maasvallei<No Text>

Ik heb een website gecontroleerd met deadlinkchecker en dan zie ik een hoop gebroken links naar whatsapp. Lijkt mij te komen door Social Share link onder artikelen.
Is daar iets aan te doen?

Show more
16:31

Analyseerde WhatsApp-linkprobleem en formuleerde oplossing
Analyseerde WhatsApp-linkprobleem en formuleerde oplossing
Kort antwoord: dit zijn grotendeels false positives, maar je gebruikt wel de verkeerde WhatsApp-URL en die kun je beter vervangen.

Wat er aan de hand is
De links wijzen naar web.whatsapp.com/send?text=.... Dat endpoint is WhatsApp Web, en dat verwacht een browsercontext met een ingelogde sessie. Als deadlinkchecker die URL bezoekt krijgt-ie geen geldige sessie en mist-ie de headers die een echte browser stuurt, dus WhatsApp gooit er een 400 tegenaan. Een echte bezoeker die op de knop klikt heeft daar geen last van, want die zit wél in een browser. De checker meldt dus iets kapot dat voor gebruikers prima werkt.

Het echte probleem zit ergens anders: web.whatsapp.com/send forceert de webversie. Klikt iemand er op mobiel op, dan word je naar WhatsApp Web gestuurd in plaats van naar de app. Dat is slechte UX, en het overgrote deel van je share-clicks komt van mobiel.

De fix
Vervang het endpoint door de officiële short link van WhatsApp. Die detecteert zelf of de bezoeker op desktop of mobiel zit en stuurt naar de juiste plek:

https://wa.me/?text=GEENCODEERDE+TEKST+EN+URL
Voor een share zonder vast telefoonnummer is dit de juiste vorm (wa.me/<nummer> is voor click-to-chat naar een specifiek nummer, dat wil je hier niet). Functioneel identiek aan https://api.whatsapp.com/send?text=..., maar wa.me is de korte aanbevolen variant.

Concreet voor jouw artikelen zou de link er zo uit moeten zien:

php
$shareText = rawurlencode($title . ' ' . $url);
$whatsappLink = 'https://wa.me/?text=' . $shareText;
Twee dingen om meteen mee te nemen
Geef die share-links een rel="nofollow ugc noopener". Het zijn outbound links naar externe parameters, en je wilt niet dat crawlers ze blijven volgen en je site-health rapporten blijven vervuilen met dit soort meldingen. Veel share-knoppen draaien sowieso beter via een onclick met window.open(), dan staat er geen crawlbare href in en ben je in één klap van het hele fenomeen af.

Dit heeft verder geen directe negatieve SEO-impact op je rankings (het zijn externe links, geen interne 404s), maar het is wel nette hygiëne en het scheelt je ruis in je monitoring.

Wat ik van je nodig heb om concreet te helpen
Waar komen die share-knoppen vandaan? De aanpak verschilt nogal:

Joomla-component of plugin (bijv. een social share extensie of iets in je template) → vaak een instelling of een override in html/
WordPress-plugin → meestal een filter of plugin-setting
Hardcoded in je template/override → dan pas je de URL-template op één plek aan
Als je me vertelt welk CMS en welke share-oplossing het is (of de URL van de site stuurt zodat ik even kan kijken), dan wijs ik je precies aan waar je het moet aanpassen.







Claude is AI and can make mistakes. Please double-check responses.
