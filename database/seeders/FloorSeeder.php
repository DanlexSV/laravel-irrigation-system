<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Floor;

class FloorSeeder extends Seeder
{
    public function run(): void
    {
        $plants = [
			[
				'name' => 'Pothos',
					'scientific_name' => 'Epipremnum aureum',
					'family' => 'Araceae',
					'water_frequency' => 7,
					'sunlight' => 'Media',
					'care_notes' => 'Tolera poca luz y riego moderado.'
			],
			[
				'name' => 'Lengua de suegra',
					'scientific_name' => 'Sansevieria trifasciata',
					'family' => 'Asparagaceae',
					'water_frequency' => 15,
					'sunlight' => 'Alta',
					'care_notes' => 'Muy resistente; tolera sequía y poca luz.'
			],
			[
				'name' => 'Cinta',
					'scientific_name' => 'Chlorophytum comosum',
					'family' => 'Asparagaceae',
					'water_frequency' => 7,
					'sunlight' => 'Media',
					'care_notes' => 'Prefiere luz indirecta; regar cuando la tierra se seque.'
			],
			[
				'name' => 'Espatifilo',
					'scientific_name' => 'Spathiphyllum wallisii',
					'family' => 'Araceae',
					'water_frequency' => 3,
					'sunlight' => 'Baja',
					'care_notes' => 'Tolera sombra; mantener el suelo húmedo sin encharcar.'
			],
			[
				'name' => 'Costilla de Adán',
					'scientific_name' => 'Monstera deliciosa',
					'family' => 'Araceae',
					'water_frequency' => 7,
					'sunlight' => 'Alta',
					'care_notes' => 'Luz brillante sin sol directo; riego moderado.'
			],
			[
				'name' => 'Filodendro',
					'scientific_name' => 'Philodendron hederaceum',
					'family' => 'Araceae',
					'water_frequency' => 7,
					'sunlight' => 'Media',
					'care_notes' => 'Tolera poca luz; regar cuando el sustrato esté seco en la superficie.'
			],
			[
				'name' => 'Tronco de Brasil',
					'scientific_name' => 'Dracaena fragrans',
					'family' => 'Asparagaceae',
					'water_frequency' => 7,
					'sunlight' => 'Media',
					'care_notes' => 'Ideal para interior; evitar el exceso de riego, prefiere sequedad entre riegos.'
			],
			[
				'name' => 'Zamioculca',
					'scientific_name' => 'Zamioculcas zamiifolia',
					'family' => 'Araceae',
					'water_frequency' => 15,
					'sunlight' => 'Baja',
					'care_notes' => 'Tolera poca luz y riego infrecuente; muy difícil de matar.'
			],
			[
				'name' => 'Ficus benjamina',
					'scientific_name' => 'Ficus benjamina',
					'family' => 'Moraceae',
					'water_frequency' => 7,
					'sunlight' => 'Alta',
					'care_notes' => 'Prefiere sitios luminosos; no le gustan los cambios bruscos ni el exceso de agua.'
			],
			[
				'name' => 'Ficus elastica',
					'scientific_name' => 'Ficus elastica',
					'family' => 'Moraceae',
					'water_frequency' => 7,
					'sunlight' => 'Alta',
					'care_notes' => 'Luz filtrada; dejar secar algo el sustrato entre riegos para evitar pudrición.'
			],
			[
				'name' => 'Cheflera',
					'scientific_name' => 'Schefflera arboricola',
					'family' => 'Araliaceae',
					'water_frequency' => 7,
					'sunlight' => 'Alta',
					'care_notes' => 'Agradece luz abundante; riego moderado sin encharcar.'
			],
			[
				'name' => 'Difenbaquia',
					'scientific_name' => 'Dieffenbachia seguine',
					'family' => 'Araceae',
					'water_frequency' => 5,
					'sunlight' => 'Media',
					'care_notes' => 'Prospera con luz indirecta; mantener el sustrato ligeramente húmedo.'
			],
			[
				'name' => 'Aglaonema',
					'scientific_name' => 'Aglaonema commutatum',
					'family' => 'Araceae',
					'water_frequency' => 7,
					'sunlight' => 'Baja',
					'care_notes' => 'Tolera poca luz; evitar corrientes frías y exceso de riego.'
			],
			[
				'name' => 'Crotón',
					'scientific_name' => 'Codiaeum variegatum',
					'family' => 'Euphorbiaceae',
					'water_frequency' => 5,
					'sunlight' => 'Alta',
					'care_notes' => 'Requiere mucha luz para colores vivos; mantener algo de humedad constante.'
			],
			[
				'name' => 'Maranta',
					'scientific_name' => 'Maranta leuconeura',
					'family' => 'Marantaceae',
					'water_frequency' => 3,
					'sunlight' => 'Baja',
					'care_notes' => 'Prefiere sombra y alta humedad; riego moderado, no demasiada luz.'
			],
			[
				'name' => 'Calathea',
					'scientific_name' => 'Calathea makoyana',
					'family' => 'Marantaceae',
					'water_frequency' => 3,
					'sunlight' => 'Baja',
					'care_notes' => 'Necesita humedad ambiental; luz filtrada y riego regular, sin agua fría.'
			],
			[
				'name' => 'Guzmania',
					'scientific_name' => 'Guzmania lingulata',
					'family' => 'Bromeliaceae',
					'water_frequency' => 7,
					'sunlight' => 'Alta',
					'care_notes' => 'Ama la humedad; luz indirecta brillante y agua en su roseta central.'
			],
			[
				'name' => 'Palma Areca',
					'scientific_name' => 'Dypsis lutescens',
					'family' => 'Arecaceae',
					'water_frequency' => 5,
					'sunlight' => 'Media',
					'care_notes' => 'Luz indirecta; mantener el sustrato húmedo, agradece la humedad ambiental.'
			],
			[
				'name' => 'Palmera de salón',
					'scientific_name' => 'Chamaedorea elegans',
					'family' => 'Arecaceae',
					'water_frequency' => 7,
					'sunlight' => 'Baja',
					'care_notes' => 'Tolera poca luz; riego moderado, no soporta el encharcamiento.'
			],
			[
				'name' => 'Kentia',
					'scientific_name' => 'Howea forsteriana',
					'family' => 'Arecaceae',
					'water_frequency' => 7,
					'sunlight' => 'Media',
					'care_notes' => 'Resistente; crece con luz media y riego espaciado, evitando excesos.'
			],
			[
				'name' => 'Aloe Vera',
					'scientific_name' => 'Aloe vera',
					'family' => 'Asphodelaceae',
					'water_frequency' => 15,
					'sunlight' => 'Alta',
					'care_notes' => 'Suculenta resistente; prefiere sol directo y riego muy espaciado.'
			],
			[
				'name' => 'Árbol de Jade',
					'scientific_name' => 'Crassula ovata',
					'family' => 'Crassulaceae',
					'water_frequency' => 14,
					'sunlight' => 'Alta',
					'care_notes' => 'Suculenta; ubicar al sol y regar solo cuando el sustrato esté seco.'
			],
			[
				'name' => 'Echeveria',
					'scientific_name' => 'Echeveria elegans',
					'family' => 'Crassulaceae',
					'water_frequency' => 14,
					'sunlight' => 'Alta',
					'care_notes' => 'Requiere mucho sol; riegos muy espaciados para evitar pudriciones.'
			],
			[
				'name' => 'Haworthia',
					'scientific_name' => 'Haworthia fasciata',
					'family' => 'Asphodelaceae',
					'water_frequency' => 14,
					'sunlight' => 'Alta',
					'care_notes' => 'Suculenta pequeña; luz brillante y riego escaso dejando secar el sustrato.'
			],
			[
				'name' => 'Cactus de Navidad',
					'scientific_name' => 'Schlumbergera truncata',
					'family' => 'Cactaceae',
					'water_frequency' => 7,
					'sunlight' => 'Media',
					'care_notes' => 'Prefiere luz brillante sin sol directo; regar cuando el sustrato se seque un poco.'
			],
			[
				'name' => 'Asiento de suegra',
					'scientific_name' => 'Echinocactus grusonii',
					'family' => 'Cactaceae',
					'water_frequency' => 15,
					'sunlight' => 'Alta',
					'care_notes' => 'Cactus desértico; pleno sol y riego muy ocasional.'
			],
			[
				'name' => 'Violeta africana',
					'scientific_name' => 'Saintpaulia ionantha',
					'family' => 'Gesneriaceae',
					'water_frequency' => 4,
					'sunlight' => 'Media',
					'care_notes' => 'Luz indirecta; regar sin mojar las hojas para evitar manchas.'
			],
			[
				'name' => 'Anturio',
					'scientific_name' => 'Anthurium andraeanum',
					'family' => 'Araceae',
					'water_frequency' => 5,
					'sunlight' => 'Media',
					'care_notes' => 'Requiere luz filtrada; mantener el suelo húmedo con riego regular.'
			],
			[
				'name' => 'Orquídea',
					'scientific_name' => 'Phalaenopsis amabilis',
					'family' => 'Orchidaceae',
					'water_frequency' => 7,
					'sunlight' => 'Media',
					'care_notes' => 'Luz indirecta; riego semanal sumergiendo la maceta brevemente.'
			],
			[
				'name' => 'Clivia',
					'scientific_name' => 'Clivia miniata',
					'family' => 'Amaryllidaceae',
					'water_frequency' => 7,
					'sunlight' => 'Media',
					'care_notes' => 'Tolera sitios sombríos; riego moderado, evitar encharcar las raíces.'
			],
			[
				'name' => 'Ciclamen',
					'scientific_name' => 'Cyclamen persicum',
					'family' => 'Primulaceae',
					'water_frequency' => 4,
					'sunlight' => 'Media',
					'care_notes' => 'Lugar fresco y luminoso; regar desde abajo evitando mojar las hojas.'
			],
			[
				'name' => 'Begonia',
					'scientific_name' => 'Begonia semperflorens',
					'family' => 'Begoniaceae',
					'water_frequency' => 4,
					'sunlight' => 'Media',
					'care_notes' => 'Luz filtrada; riego frecuente en pequeñas cantidades, sin encharcar.'
			],
			[
				'name' => 'Geranio',
					'scientific_name' => 'Pelargonium x hortorum',
					'family' => 'Geraniaceae',
					'water_frequency' => 3,
					'sunlight' => 'Alta',
					'care_notes' => 'Necesita sol para florecer; riego regular, reducir en invierno.'
			],
			[
				'name' => 'Hibisco',
					'scientific_name' => 'Hibiscus rosa-sinensis',
					'family' => 'Malvaceae',
					'water_frequency' => 3,
					'sunlight' => 'Alta',
					'care_notes' => 'Pleno sol para abundantes flores; riego frecuente en época cálida.'
			],
			[
				'name' => 'Lavanda',
					'scientific_name' => 'Lavandula angustifolia',
					'family' => 'Lamiaceae',
					'water_frequency' => 7,
					'sunlight' => 'Alta',
					'care_notes' => 'Planta mediterránea; pleno sol y suelo bien drenado con riego ocasional.'
			],
			[
				'name' => 'Romero',
					'scientific_name' => 'Rosmarinus officinalis',
					'family' => 'Lamiaceae',
					'water_frequency' => 7,
					'sunlight' => 'Alta',
					'care_notes' => 'Aromática resistente; prefiere sol pleno y riegos espaciados.'
			],
			[
				'name' => 'Albahaca',
					'scientific_name' => 'Ocimum basilicum',
					'family' => 'Lamiaceae',
					'water_frequency' => 3,
					'sunlight' => 'Alta',
					'care_notes' => 'Hierba anual; necesita sol y riego frecuente, evitar encharcamientos.'
			],
			[
				'name' => 'Tomillo',
					'scientific_name' => 'Thymus vulgaris',
					'family' => 'Lamiaceae',
					'water_frequency' => 7,
					'sunlight' => 'Alta',
					'care_notes' => 'Hierba resistente; pleno sol y riego moderado, tolera sequía.'
			],
			[
				'name' => 'Menta',
					'scientific_name' => 'Mentha spicata',
					'family' => 'Lamiaceae',
					'water_frequency' => 2,
					'sunlight' => 'Media',
					'care_notes' => 'Hierba invasiva; crece en semisombra y requiere suelo siempre húmedo.'
			],
			[
				'name' => 'Perejil',
					'scientific_name' => 'Petroselinum crispum',
					'family' => 'Apiaceae',
					'water_frequency' => 3,
					'sunlight' => 'Media',
					'care_notes' => 'Necesita sol parcial; riego frecuente para mantener el sustrato húmedo.'
			],
			[
				'name' => 'Orégano',
					'scientific_name' => 'Origanum vulgare',
					'family' => 'Lamiaceae',
					'water_frequency' => 5,
					'sunlight' => 'Alta',
					'care_notes' => 'Hierba mediterránea; pleno sol y riego moderado, tolera sequía.'
			],
			[
				'name' => 'Hiedra',
					'scientific_name' => 'Hedera helix',
					'family' => 'Araliaceae',
					'water_frequency' => 5,
					'sunlight' => 'Baja',
					'care_notes' => 'Trepadora resistente; tolera sombra y requiere riego moderado.'
			],
			[
				'name' => 'Cóleo',
					'scientific_name' => 'Plectranthus scutellarioides',
					'family' => 'Lamiaceae',
					'water_frequency' => 3,
					'sunlight' => 'Media',
					'care_notes' => 'Hojas de colores vivos; semisombra y suelo húmedo sin encharcar.'
			],
			[
				'name' => 'Amor de hombre',
					'scientific_name' => 'Tradescantia zebrina',
					'family' => 'Commelinaceae',
					'water_frequency' => 4,
					'sunlight' => 'Media',
					'care_notes' => 'Fácil de propagar; luz media y riego cuando el sustrato se seque.'
			],
			[
				'name' => 'Peperomia',
					'scientific_name' => 'Peperomia obtusifolia',
					'family' => 'Piperaceae',
					'water_frequency' => 7,
					'sunlight' => 'Media',
					'care_notes' => 'Tolera luz baja; riego moderado, sensible al exceso de agua.'
			],
			[
				'name' => 'Flor de Pascua',
					'scientific_name' => 'Euphorbia pulcherrima',
					'family' => 'Euphorbiaceae',
					'water_frequency' => 3,
					'sunlight' => 'Alta',
					'care_notes' => 'Necesita luz tras la época de floración; riego moderado, no tolera frío.'
			],
			[
				'name' => 'Crisantemo',
					'scientific_name' => 'Chrysanthemum morifolium',
					'family' => 'Asteraceae',
					'water_frequency' => 3,
					'sunlight' => 'Alta',
					'care_notes' => 'Florece en otoño; requiere sol y riego abundante durante floración.'
			],
			[
				'name' => 'Gardenia',
					'scientific_name' => 'Gardenia jasminoides',
					'family' => 'Rubiaceae',
					'water_frequency' => 3,
					'sunlight' => 'Alta',
					'care_notes' => 'Exigente; luz brillante, alta humedad y riego con agua sin cal.'
			],
			[
				'name' => 'Azalea',
					'scientific_name' => 'Rhododendron simsii',
					'family' => 'Ericaceae',
					'water_frequency' => 3,
					'sunlight' => 'Media',
					'care_notes' => 'Prefiere semisombra y suelo ácido; riego frecuente sin encharcar.'
			],
			[
				'name' => 'Bambú de la suerte',
					'scientific_name' => 'Dracaena sanderiana',
					'family' => 'Asparagaceae',
					'water_frequency' => 7,
					'sunlight' => 'Baja',
					'care_notes' => 'Suele crecer en agua; tolera poca luz y se debe cambiar el agua semanalmente.'
			]
		];

        foreach ($plants as $plant) {
            Floor::create($plant);
        }
    }
}
