<main>
    <div class="panel" id="main_panel">
        <h1 id="title">Realtime Support Chat(ReSC)</h1>
    <section id="main_container">
        <h2>Autori</h2>
        <ul typeof="sa:ContributorRole" property="schema:author">
            <li>
                <meta property="schema:givenName" content="Andreea">
                <meta property="schema:familyName" content="Condurache">
                <span property="schema:name">Andreea Condurache</span>
            </li>
            <li>
                <meta property="schema:givenName" content="Cătălin">
                <meta property="schema:familyName" content="Ancuței">
                <span property="schema:name">Cătălin Ancuței</span>
            </li>
        </ul>
        <h2>Cuprins</h2>
        <ol>
            <li><a href="#introduction">Introducere</a></li>
            <ul>
                <li>1.1 <a href="#purpose">Scop</a></li>
                <li>1.2 <a href="#conventions">Convențiile documentelor</a></li>
                <li>1.3 <a href="#suggestions">Publicul destinat și sugestiile de lectură</a></li>
                <li>1.4 <a href="#product_purpose">Domeniul de aplicare al produsului</a><br></li>
            </ul>
            <li><a href="#description">Descriere generală</a></li>
            <ul>
                <li>2.1 <a href="#perspectiva">Perspectiva produsului</a></li>
                <li>2.2 <a href="#clase">Clase de utilizator și caracteristici</a></li>
                <li>2.3 <a href="#operare">Mediul de operare</a></li>
                <li>2.4 <a href="#constrangeri">Constrângeri de proiectare și implementare</a></li>
            </ul>
            <li><a href="#interfata">Cerințe de interfață externă</a></li>
            <ul>
                <li>3.1 <a href="#utiliz">Interfețe utilizator</a></li>
            </ul>
        </ol>
        <hr>
        <section typeof="sa:Abstract" id="abstract" role="doc-abstract">
            <h2 id="introduction">1.Introducere</h2>
            <h5>ReSC este o aplicatie care ofera administratorilor posibilitatea de a comunica in timp real cu clientii, fiind usor de utilizat. Design-ul este unul atractiv care ofera numeroase perspective de personalizare a contentului.
            </h5>
        </section>

        <h3 id="purpose">1.1 Scop</h3>
        <p>Aceasta aplicatie ofera o solutie Web prin care administratorii pot sa comunice in timp real. Comunicarea poate fi de tip 1 la 1 sau 1 la multi cu utilizatorii. Pentru a adauga in pagina un chat este necesar ca acestia sa incarce un script extern
            JS intr-un site Web.<br> Pentru a raspunde in timp real la conversatii, administratorii vor avea la dispozitie alta aplicatie, plus un API rest sau graphQL, urmand sa le integreze in propriile Sisteme de Content Management (CRM). Pentru o folosire
            cat mai atractiva, acestia pot personaliza diverse proprietati ale chat-ului, cum ar fi culorile temei din chat, pozitia in pagina, gruparea conversatiilor in functie de diverse criterii, modul de afisare a avatarelor. De asemenea, va fi posibila
            convertirea cuvintelor in emoji-uri si traducerea automata folosind un API public.
        </p>

        <h3 id="conventions">1.2 Convențiile documentelor</h3>
        <p>In scrierea acestui SRS am avut in vedere parametrii normali de indentare si pozitionare in pagina.Titlul este scris cu "h1", fiind bold si cel mai mare din pagina, urmand ca fiecare titlu de paragraf sa fie scris cu"h2", iar subtitlurile cu "h3".
            Am considerat informatiile din paragraful de introducere fiind mai importante decat celelalte, de aceea am folosit "h5" bold, dar un scris nu prea mare. Restul paragrafelor sunt scrise in "p". Delimitarea categoriile am facut-o printr-un "hr".
        </p>
        <h3 id="suggestions">1.3 Publicul destinat și sugestiile de lectură</h3>
        <p>Aplicatia este destinata administratorilor pentru a comunica in timp real cu utilizatorii precum si developer-ilor,tester-ilor. Utilizatorii sunt in general persoane care isi doresc asistenta in legaturile cu problemele intampinate. Acest document
            contine un cuprins interactiv pentru a vizualiza exact obiectul de interes.
        </p>
        <hr>

        <h2 id="description">2. Descriere generală</h2>

        <h3 id="perspectiva">2.1 Perspectiva produsului</h3>

        <p>
            Aplicatia ReSC poate fi folosita in diverse domenii. Aceasta este alcatuita dintr-un chat support si aplicatia de administrare. ReSC-ul poate fi personalizat cu usurinta, asadar este posibila combinarea acestuia cu orice aplicatie compatibila.
        </p>
        <h3 id="clase">2.2 Clase de utilizator și caracteristici</h3>
        <p>
            Cei care folosesc constant aplicatia vor fi in special administratorii firmei care isi doresc o imbunatatire in sistem prin obtinerea unei comunicari cu clientul fara a intampina dificultati. ReSC este o aplicatie universala, nu e destinata in mod special
            unui anumit domeniu si poate fi folosit de orice companie isi doreste comunicarea cu clientii.
        </p>
        <h3 id="operare">2.3 Mediul de operare</h3>
        <p>
            Aplicatia va fi compatibila pe orice dispozitiv functional cu acces la internet prin cablu sau date si va putea fi lansata atat pe Windows cat si pe Linux. Universalitatea ii ofera un plus considerabil cand vine vorba de utilizare.
        </p>
        <h3 id="constrangeri">2.4 Constrângeri de proiectare și implementare</h3>
        <p>
            ReSC este o aplicatie practica care isi atinge cu succes scopul pentru care a fost creata.Inevitabil limitarea intervine din punct de vedere al utilizarii deoarece este utilizata doar atunci cand este necesara comunicarea administartor client pentru a
            rezolva o problema sau pentru a clarifica o nelamurire.
        </p>

        <hr>
        <h2 id="interfata">3. Cerințe de interfață externă</h2>

        <h3 id="utiliz">3.1 Interfețe utilizator</h3>
        <p typeof="sa:accessibilitySummary">
            Administratorii își pot integra chat-ul în propriul website, punând la dispoziție utilizatorilor un chat prin intermediul căruia pot comunica. Chatul permite atat minimizarea cat si inchiderea.
        </p>
        <figure typeof="sa:image">
            <img src="resources/docs/ochat.png" alt="open" style="width: 250px; height: 300px">
        </figure>
        <figure typeof="sa:image">
            <img src="resources/docs/cchat.png" alt="colapse" style="width: 400px; height: 150px">
        </figure>
        <p typeof="sa:accessibilitySummary">
            Administratorii pot configura chat-ul prin intermediul aplicației puse la dispoziție. Acestia trebuie sa se inregistreze folosind formularul pus la dispoziție de către aplicație. Dupa ce acestia s-au inregistrat, vor primi pe mail link-ul catre scriptul
            ce va putea fi inserat in pagina.
        </p>
        <figure typeof="sa:image">
            <img src="resources/docs/register.png" alt="Register" style="width: 300px; height: 300px">
        </figure>
        <p typeof="sa:accessibilitySummary">Dupa inregistrare, acestia se pot loga in contul propriu.</p>
        <figure typeof="sa:image">
            <img src="resources/docs/login.png" alt="Login" style="width: 300px; height: 300px">
        </figure>
        <p typeof="sa:accessibilitySummary">Odata logati, acestia pot intra pe pagina de setari unde pot configura diferite aspecte ale chat-ului.</p>
        <p typeof="sa:accessibilitySummary">Acestia pot selecta culoarea pentru fiecare componenta a chatului, dand click pe partea corespunzatoare si selectand culoarea.</p>
        <figure typeof="sa:image">
            <img src="resources/docs/colors.png" alt="colors" style="width: 300px; height: 300px">
        </figure>
        <p>Pozitia in pagina a chatului se poate schimba dand click pe patratul corespunzator (patratul verde corespunde pozitiei din dreapta jos).</p>
        <figure typeof="sa:image">
            <img src="resources/docs/positions.png" alt="positions" style="width: 300px; height: 300px">
        </figure>
        <p typeof="sa:accessibilitySummary">De asemenea se pot seta functii de callback, pentru ca administratorul paginii sa poata controla ce se intampla cand se apasa butonul de inchidere si de minimizare a chat-ului, cat si numele clasei folosite pentru pentru functiile chat-ului cat si numele
            instantei.
        </p>
        <figure typeof="sa:image">
            <img src="resources/docs/callbacks.png" alt="callbacks" style="width: 300px; height: 300px">
        </figure>
        <p typeof="sa:accessibilitySummary">Pe pagina corespunzatoare chat-ului, se poate comunica cu utilizatorii ce au trimis un mesaj.</p>
        <figure typeof="sa:image">
            <img src="resources/docs/chat.png" alt="callbacks" style="width: 600px; height: 300px">
        </figure>
                <ul class="main_panel__text">
                </ul>
    </section>
</main>