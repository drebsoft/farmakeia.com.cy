<x-guest-layout>
    <div x-data="{ openPanel: 1 }">
        <div class="max-w-screen-xl mx-auto py-12 px-4 sm:py-16 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto">
                <h2 class="text-center text-3xl leading-9 font-extrabold text-gray-900 sm:text-4xl sm:leading-10">
                    Πως λειτουργεί;
                </h2>
                <div class="mt-6 border-t-2 border-gray-200 pt-6">
                    <dl>
                        <div>
                            <dt class="text-lg leading-7">
                                <button x-description="Expand/collapse question button"
                                        @click="openPanel = (openPanel === 1 ? null : 1)"
                                        class="text-left w-full flex justify-between items-start text-gray-400 focus:outline-none focus:text-gray-900"
                                        x-bind:aria-expanded="openPanel === 1"
                                >
                                    <span class="font-medium text-gray-900">
                                        Τι είναι το farmakeia.com.cy;
                                    </span>
                                    <span class="ml-6 h-7 flex items-center">
                                        <svg class="h-6 w-6 transform rotate-0"
                                             x-description="Heroicon name: chevron-down"
                                             x-state:on="Open" x-state:off="Closed"
                                             x-bind:class="{ '-rotate-180': openPanel === 1, 'rotate-0': !(openPanel === 1) }"
                                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke="currentColor"
                                        >
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 9l-7 7-7-7"
                                            ></path>
                                        </svg>
                                    </span>
                                </button>
                            </dt>
                            <dd class="mt-2 pr-12" x-show="openPanel === 1" style="display: none;">
                                <p class="text-base leading-6 text-gray-500">
                                    Το farmakeia.com.cy είναι ένα εργαλείο εύρεσης φαρμακείων για όλη την Κύπρο.
                                    Μπορείτε να αναζητήσετε
                                    φαρμακεία ανά επαρχία, να τα δείτε στο χάρτη, να μάθετε ποια εφημερεύουν ανά ημέρα,
                                    και να βρείτε τηλέφωνα και
                                    οδηγίες.
                                </p>
                            </dd>
                        </div>
                        <div class="mt-6 border-t border-gray-200 pt-6">
                            <div>
                                <dt class="text-lg leading-7">
                                    <button x-description="Expand/collapse question button"
                                            @click="openPanel = (openPanel === 2 ? null : 2)"
                                            class="text-left w-full flex justify-between items-start text-gray-400 focus:outline-none focus:text-gray-900"
                                            x-bind:aria-expanded="openPanel === 2"
                                    >
                                        <span class="font-medium text-gray-900">
                                          Πώς το χρησιμοποιώ;
                                        </span>
                                        <span class="ml-6 h-7 flex items-center">
                                          <svg class="h-6 w-6 transform rotate-0"
                                               x-description="Heroicon name: chevron-down"
                                               x-state:on="Open" x-state:off="Closed"
                                               x-bind:class="{ '-rotate-180': openPanel === 2, 'rotate-0': !(openPanel === 2) }"
                                               xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                               stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </span>
                                    </button>
                                </dt>
                                <dd class="mt-2 pr-12" x-show="openPanel === 2" style="display: none;">
                                    <p class="text-base leading-6 text-gray-500">
                                        Στην αρχική σελίδα του farmakeia.com.cy θα βρείτε ένα χάρτη της Κύπρου. Πατώντας
                                        σε οποιαδήποτε από
                                        τις επαρχίες, θα σας ανοίξει ο κατάλογος φαρμακείων για αυτή την επαρχία. Σε
                                        αυτό το σημείο αξίζει να σημειωθεί
                                        πως τα φαρμακεία που θα βρείτε στην ιστοσελίδα δεν είναι όλα τα αδειοδοτημένα
                                        φαρμακεία της επικράτειας, αλλά
                                        εκείνα που αναφέρονται έστω και μία φορά στους καταλόγους του Υπουργείου Υγείας
                                        για τα εφημερεύοντα
                                        φαρμακεία.
                                    </p>
                                    <br>
                                    <p class="text-base leading-6 text-gray-500">
                                        Στην κορυφή της λίστας θα δείτε τα φαρμακεία που εφημερεύουν αυτή τη στιγμή
                                        (εφόσον υπάρχουν). Για κάθε φαρμακείο θα δείτε την ονομασία του, την περιοχή
                                        όπου βρίσκεται, και τη διεύθυνσή του. Μπορείτε να πατήσετε το κουμπί με το
                                        τηλέφωνο στα δεξιά για να καλέσετε το φαρμακείο, ή το κουμπί με το χάρτη για να
                                        μεταβείτε στο Google Maps και να λάβετε οδηγίες προς τη διεύθυνση του
                                        φαρμακείου. Αν πατήσετε στην ονομασία θα ανοίξετε μια σελίδα με παραπάνω
                                        πληροφορίες. Εκεί θα δείτε τις επόμενες εφημερίες που θα έχει το εν λόγω
                                        φαρμακείο καθώς και τη θέση του στο χάρτη. Επιπλέον, για όσα φαρμακεία έχουν
                                        αυτή την πληροφορία, θα μπορείτε να δείτε και το τηλέφωνο οικίας που έχει
                                        δηλωθεί.
                                    </p>
                                    <br>
                                    <p class="text-base leading-6 text-gray-500">
                                        Εναλλακτικά, μπορείτε να επιλέξετε την Προβολή Χάρτη από την κορυφή της σελίδας
                                        και να δείτε όλα τα
                                        φαρμακεία που υπάρχουν στη βάση του farmakeia.com.cy σε έναν διαδραστικό χάρτη
                                        του Google Maps. Πατώντας σε
                                        οποιοδήποτε από τα σημεία μπορείτε να δείτε την ονομασία του φαρμακείου και να
                                        μεταβείτε στη σελίδα του, να το
                                        καλέσετε απευθείας, ή να λάβετε οδηγίες προς τη διεύθυνσή του.
                                    </p>
                                </dd>
                            </div>
                        </div>
                        <div class="mt-6 border-t border-gray-200 pt-6">
                            <div>
                                <dt class="text-lg leading-7">
                                    <button x-description="Expand/collapse question button"
                                            @click="openPanel = (openPanel === 3 ? null : 3)"
                                            class="text-left w-full flex justify-between items-start text-gray-400 focus:outline-none focus:text-gray-900"
                                            x-bind:aria-expanded="openPanel === 3"
                                    >
                                        <span class="font-medium text-gray-900">
                                          Πού βρίσκετε αυτές τις πληροφορίες;
                                        </span>
                                        <span class="ml-6 h-7 flex items-center">
                                          <svg class="rotate-0 h-6 w-6 transform"
                                               x-description="Heroicon name: chevron-down"
                                               x-state:on="Open" x-state:off="Closed"
                                               x-bind:class="{ '-rotate-180': openPanel === 3, 'rotate-0': !(openPanel === 3) }"
                                               xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                               stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </span>
                                    </button>
                                </dt>
                                <dd class="mt-2 pr-12" x-show="openPanel === 3" style="display: none;">
                                    <p class="text-base leading-6 text-gray-500">
                                        Όλες οι πληροφορίες που βλέπετε στο farmakeia.com.cy προέρχονται από τους
                                        καταλόγους του Υπουργείου
                                        Υγείας με τα εφημερεύοντα φαρμακεία. Οι θέσεις των φαρμακείων στο χάρτη
                                        διαβάζονται από το Google Maps, σύμφωνα
                                        με τη διεύθυνση που έχει καταχωρημένη το Υπουργείο.
                                    </p>
                                    <br>
                                    <p class="text-base leading-6 text-gray-500">
                                        Λόγω του ότι όλα τα δεδομένα εισέρχονται στη βάση του farmakeia.com.cy
                                        αυτοματοποιημένα, υπάρχει
                                        περίπτωση ορισμένες πληροφορίες να είναι ελλιπείς ή ανακριβείς. Παρότι η ομάδα
                                        μας καταβάλλει κάθε προσπάθεια
                                        για έγκαιρες διορθώσεις, η ιστοσελίδα παραμένει απλά ένας οδηγός και σε
                                        περίπτωση εκτάκτου ανάγκης σας
                                        συνιστούμε και προτρέπουμε να καλείτε απευθείας το 112 για παροχή άμεσης
                                        βοήθειας.
                                    </p>
                                </dd>
                            </div>
                        </div>
                        <div class="mt-6 border-t border-gray-200 pt-6">
                            <div>
                                <dt class="text-lg leading-7">
                                    <button x-description="Expand/collapse question button"
                                            @click="openPanel = (openPanel === 4 ? null : 4)"
                                            class="text-left w-full flex justify-between items-start text-gray-400 focus:outline-none focus:text-gray-900"
                                            x-bind:aria-expanded="openPanel === 4"
                                    >
                                        <span class="font-medium text-gray-900">
                                          Εντόπισα ένα λάθος! Πώς μπορώ να σας ενημερώσω;
                                        </span>
                                        <span class="ml-6 h-7 flex items-center">
                                          <svg class="rotate-0 h-6 w-6 transform"
                                               x-description="Heroicon name: chevron-down"
                                               x-state:on="Open" x-state:off="Closed"
                                               x-bind:class="{ '-rotate-180': openPanel === 4, 'rotate-0': !(openPanel === 4) }"
                                               xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                               stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </span>
                                    </button>
                                </dt>
                                <dd class="mt-2 pr-12" x-show="openPanel === 4" style="display: none;">
                                    <p class="text-base leading-6 text-gray-500">
                                        Αν έχετε εντοπίσει κάποιο λάθος στις πληροφορίες, τις εφημερίες, ή τη θέση στο
                                        χάρτη κάποιου
                                        φαρμακείου, μην διστάσετε να επικοινωνήσετε μαζί μας <a
                                            href="mailto:support@farmakeia.com.cy"
                                            class="text-blue-500">αποστέλλοντάς μας ένα email</a>.
                                    </p>
                                </dd>
                            </div>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
