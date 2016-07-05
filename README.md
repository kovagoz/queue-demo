RabbitMQ demo
=============

Ez a projekt egy egyszerű demonstráció a _RabbitMQ_ működésére.

Szükséges szoftverek
--------------------

- VirtualBox
- Vagrant (>= 1.8.0) + 512MB RAM

A Vagrant a _8000-8004_-es portokat fogja használja _localhoston_, ezeket tedd szabaddá.

Telepítés
---------

Klónozd le a Git repót, és indítsd el a virtuális gépet.

```
git clone https://github.com/kovagoz/queue-demo
cd queue-demo
vagrant up
```

A folyamat eltarthat néhány percig.

Ha készen van, az oldal a [http://localhost:8000/](http://localhost:8000/) címen lesz elérhető.

Használat
---------

A jobb felső sarokban lévő gombra kattintva lehet új jobokat elhelyezni a queue-ban. Az eseménynapló a képernyő fennmaradó részén fog megjelenni, és a továbbiakban automatikusan frissül.

Működés
-------

A gombra kattintva egy AJAX request megy a szerver felé. A request befut a megfelelő kontrollerbe, és ott az `App\Domain\MessageGenerator` egy új üzenetet helyez el az elsődleges queue-ban. A queue másik végén az `App\Domain\MessageProcessor` kapja el és dolgozza fel az üzeneteket.

A `MessageProcessor` az `App\Domain\Handlers\DefaultHandler`-nek adja át a kapott üzenetet, ami 1:3 arányban hibára fut. Hiba esetén az üzenetet továbbadja az `App\Domain\Handlers\ErrorHandler`-nek. Az `ErrorHandler` megvizsgálja, hogy az üzenet hányadik alkalommal került feldolgozásra (ezt az információt az `App\Queue\Amqp\Message` hordozza magában). Ha ez volt a harmadik hiba, akkor kiveszi a queue-ból, és az `App\Mail\Transport\Sendmail`-en keresztül emailt küld egy fiktív címre. Egyébként egy pihentető queue-ban helyezi el az üzenetet, ahonnan egy másodperc múlva átkerül ismét az elsődleges queue-ba.

A `MessageGenerator` és a `MessageProcessor` minden fontos eseménynél egy `App\Contracts\Log\Loggable` objektumot ad át az `App\Event\EventManager`-nek. Ezeket az eseményeket figyeli az `App\Domain\EventLogger`, és naplózza azokat az `App\Log\Logger`-en keresztül az adatbázisba.

A böngészőben futó _Vue.js_ app másodpercenként hívogatja a szervert friss log bejegyzésekért.

A `MessageProcessor`-t a _Supervisor_ futtatja és tartja életben.

Levelezés
---------

Az app által kiküldött levelek nem hagyják el a virtuális gépet, azok megtekinthetők a [http://localhost:8002/](http://localhost:8002/) címen, a _Mailcatcher_ webes felületén.

API
---

Telepítésnél automatikusan generálódik egy API dokumentáció, ami a [http://localhost:8000/doc](http://localhost:8000/doc) címen érhető el.

Tesztelés
---------

Unit tesztek futtatása, és a coding style ellenőrzése:

```
vagrant ssh
cd /vagrant
make test
```

Továbbfejlesztés
----------------

- WebSocket használata log frissítésre AJAX polling helyett.
- A levélküldés is mehetne queue / worker alapon, hogy ne fogja le a `MessageProcessor`-t.
- A naplózás szintén aszinkronizálható, így a `MessageGenerator` és a `MessageProcessor` nem függne az adatbázistól.
