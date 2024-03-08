
# Comandi git per interagire con GitHub
N.B:
Abbiamo deciso di avere:

- il branch main (su cui carichiamo le versioni funzionanti), 
- il branch develop (su cui costruiamo man mano il gioco),
- altri branch (locali o no), che partono da develop, su cui creiamo nuove funzioanlità. 
---
### **Procedura per scaricare repository remota:**

* `git clone <URL>`<br>
Con questa operazione avremo scaricato la repo, ma tracciamo solo il branch di default (in questo caso main). 
(Per verificare questo digitare `git branch` e vediamo solo main, mentre con `git branch -r` vediamo gli altri branch della repo che però non sono tracciati)

### **Procedura per tracciare il branch che vogliamo:**

* `git switch <nomeBranch>`<br>
 Questo comando crea un nuovo branch locale, settandolo in maniera che tracci il branch con quello stesso nome. (Quindi, una volta scaricata la repo, faccio git switch develop per tenere traccia di questo branch). Il nomeBranch deve corrispondere ad un branch esistente. <br>
(Dopo `git switch develop` ad esempio verificare con `git branch -a` di vedere adesso il branch develop) <br>
Questo comando viene utilizzato anche quando ho già alcuni branch e voglio switchare tra di loro. <br>

* In alternativa si può usare il comando:
`git checkout --track origin/<nomeBranch>`

### **Procedura per scaricare/aggiornare i cambiamenti fatti da altri caricati su GitHub**

* `git pull <remote> <branch>`<br>
Con il comando pull è come eseguire i comandi fetch + merge. 
Questo comando bisogna lanciarlo nel branch che vogliamo aggiornare.
Se la merge riguarda modifiche su uno stesso o più file si possono verificare dei merge conflicts che bisogna risolvere.

* `git pull`<br>
Lanciando questo comando git assume che il remote di default sia origin e che vogliamo aggiornare il branch su cui ci troviamo.

### **Procedura per caricare su GitHub**

* Come prima cosa bisogna fare una pull per risolvere eventuali merge conflicts, dopodichè <br>

* `git push <remote> <branch>`
