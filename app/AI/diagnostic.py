import sys
import json
import re

# Knowledge Base: Problem definitions with weighted keywords
knowledge_base = [
    {
        "id": "brakes",
        "service": "Brake Service",
        "problem": "Brake System Degradation",
        "cause": "Worn brake pads, contaminated rotors, or air in the hydraulic lines causing safety risks.",
        "keywords": {"brake": 5, "squeak": 3, "stop": 2, "noise": 1, "pedal": 2, "lever": 2}
    },
    {
        "id": "engine_start",
        "service": "Electrical",
        "problem": "Ignition / Starting Failure",
        "cause": "Depleted battery voltage, faulty spark plugs, or a failing starter motor circuit.",
        "keywords": {"start": 5, "ignition": 4, "dead": 3, "click": 2, "battery": 4, "spark": 3}
    },
    {
        "id": "oil_leak",
        "service": "Oil Change",
        "problem": "Fluid Leakage Detected",
        "cause": "Engine gasket failure, loose drain plug, or degraded seals leading to lubrication loss.",
        "keywords": {"oil": 5, "leak": 4, "drop": 3, "grease": 2, "engine": 1}
    },
    {
        "id": "fuel_system",
        "service": "Engine Repair",
        "problem": "Combustion Imbalance",
        "cause": "Carbon buildup in fuel injectors or improper air-fuel mixture causing performance drop.",
        "keywords": {"smoke": 5, "black": 3, "fuel": 4, "misfire": 5, "acceleration": 2}
    },
    {
        "id": "tires",
        "service": "Tires & Wheels",
        "problem": "Handling & Stability Issue",
        "cause": "Uneven tire wear pattern, low pressure, or misaligned wheel bearings.",
        "keywords": {"tire": 5, "wobble": 4, "handle": 3, "steering": 3, "alignment": 4}
    },

    # 🔥 NEW SERVICES ADDED
    {
        "id": "chain",
        "service": "Chain & Sprocket Service",
        "problem": "Power Transmission Issue",
        "cause": "Loose or worn chain causing jerks and inefficient power delivery.",
        "keywords": {"chain": 5, "sprocket": 4, "jerk": 3, "loose": 2, "tight": 2}
    },
    {
        "id": "suspension",
        "service": "Suspension Repair",
        "problem": "Shock Absorption Failure",
        "cause": "Damaged suspension or worn shock absorbers causing uncomfortable ride.",
        "keywords": {"shock": 5, "suspension": 5, "bounce": 3, "jump": 2, "rough": 2}
    },
    {
        "id": "cooling",
        "service": "Cooling System Service",
        "problem": "Engine Overheating",
        "cause": "Coolant leakage or radiator blockage causing high engine temperature.",
        "keywords": {"heat": 5, "overheat": 5, "hot": 3, "temperature": 3, "radiator": 4}
    },
    {
        "id": "clutch",
        "service": "Clutch Repair",
        "problem": "Gear Engagement Issue",
        "cause": "Worn clutch plates causing slipping or difficulty in gear shifting.",
        "keywords": {"clutch": 5, "gear": 4, "shift": 3, "slip": 4, "hard": 2}
    },
    {
        "id": "lights",
        "service": "Lighting System Repair",
        "problem": "Lighting Failure",
        "cause": "Faulty wiring or blown bulbs affecting visibility.",
        "keywords": {"light": 5, "headlight": 5, "indicator": 4, "bulb": 3, "dark": 2}
    },
    {
        "id": "horn",
        "service": "Horn Repair",
        "problem": "Horn Not Working",
        "cause": "Electrical issue or horn unit failure.",
        "keywords": {"horn": 5, "sound": 2, "no horn": 5}
    },
    {
        "id": "battery_drain",
        "service": "Battery Replacement",
        "problem": "Battery Drain Issue",
        "cause": "Old battery or electrical leakage causing frequent discharge.",
        "keywords": {"battery drain": 5, "discharge": 4, "low battery": 4}
    },
    {
        "id": "exhaust",
        "service": "Exhaust System Repair",
        "problem": "Exhaust Noise / Smoke",
        "cause": "Damaged silencer or exhaust leakage.",
        "keywords": {"exhaust": 5, "silencer": 4, "loud": 3, "smoke": 2}
    }
]

def analyze_problem(description):
    description = description.lower()
    best_match = None
    max_score = 0

    for entry in knowledge_base:
        score = 0
        for keyword, weight in entry["keywords"].items():
            if keyword in description:
                score += weight

        if score > max_score:
            max_score = score
            best_match = entry

    if best_match and max_score > 2:
        return {
            "success": True,
            "problem": best_match["problem"],
            "cause": best_match["cause"],
            "service": best_match["service"],
            "confidence": min(100, (max_score / 10.0) * 100)
        }
    else:
        return {
            "success": True,
            "problem": "Generalized Mechanical Wear",
            "cause": "Multiple subtle symptoms detected. Requires professional diagnostic scan for precise identification.",
            "service": "Inspection",
            "confidence": 40
        }

if __name__ == "__main__":
    if len(sys.argv) > 1:
        input_desc = sys.argv[1]
        result = analyze_problem(input_desc)
        print(json.dumps(result))
    else:
        print(json.dumps({"success": False, "error": "No description provided"}))
