import React, { useState } from "react";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { Textarea } from "@/components/ui/textarea";
import { Button } from "@/components/ui/button";
import { Label } from "@/components/ui/label";
import { Save, XCircle } from "lucide-react";

export default function EventForm({ event, onSubmit, onCancel, isProcessing }) {
  const [formData, setFormData] = useState(event || {
    titel: "",
    omschrijving: "",
    datum: "",
    tijd: "",
    locatie: ""
  });

  const handleSubmit = (e) => {
    e.preventDefault();
    onSubmit(formData);
  };

  const handleChange = (field, value) => {
    setFormData(prev => ({ ...prev, [field]: value }));
  };

  return (
    <Card className="bg-white/95 backdrop-blur-sm shadow-xl border-2 border-purple-200">
      <CardHeader className="border-b border-purple-100">
        <CardTitle className="text-2xl font-bold text-gray-900">
          {event ? "Optreden Bewerken" : "Nieuw Optreden Toevoegen"}
        </CardTitle>
      </CardHeader>
      <CardContent className="pt-6">
        <form onSubmit={handleSubmit} className="space-y-6">
          <div className="space-y-2">
            <Label htmlFor="titel" className="text-gray-700 font-semibold">
              Titel *
            </Label>
            <Input
              id="titel"
              value={formData.titel}
              onChange={(e) => handleChange("titel", e.target.value)}
              placeholder="bijv. Concert in Paradiso"
              required
              className="border-purple-200 focus:border-purple-400"
            />
          </div>

          <div className="space-y-2">
            <Label htmlFor="omschrijving" className="text-gray-700 font-semibold">
              Omschrijving
            </Label>
            <Textarea
              id="omschrijving"
              value={formData.omschrijving}
              onChange={(e) => handleChange("omschrijving", e.target.value)}
              placeholder="Beschrijf je optreden..."
              rows={4}
              className="border-purple-200 focus:border-purple-400"
            />
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div className="space-y-2">
              <Label htmlFor="datum" className="text-gray-700 font-semibold">
                Datum *
              </Label>
              <Input
                id="datum"
                type="date"
                value={formData.datum}
                onChange={(e) => handleChange("datum", e.target.value)}
                required
                className="border-purple-200 focus:border-purple-400"
              />
            </div>

            <div className="space-y-2">
              <Label htmlFor="tijd" className="text-gray-700 font-semibold">
                Tijd *
              </Label>
              <Input
                id="tijd"
                type="time"
                value={formData.tijd}
                onChange={(e) => handleChange("tijd", e.target.value)}
                required
                className="border-purple-200 focus:border-purple-400"
              />
            </div>
          </div>

          <div className="space-y-2">
            <Label htmlFor="locatie" className="text-gray-700 font-semibold">
              Locatie
            </Label>
            <Input
              id="locatie"
              value={formData.locatie}
              onChange={(e) => handleChange("locatie", e.target.value)}
              placeholder="bijv. Paradiso, Amsterdam"
              className="border-purple-200 focus:border-purple-400"
            />
          </div>

          <div className="flex gap-3 pt-4">
            <Button
              type="button"
              variant="outline"
              onClick={onCancel}
              disabled={isProcessing}
              className="flex-1 border-gray-300"
            >
              <XCircle className="w-4 h-4 mr-2" />
              Annuleren
            </Button>
            <Button
              type="submit"
              disabled={isProcessing}
              className="flex-1 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white"
            >
              <Save className="w-4 h-4 mr-2" />
              {isProcessing ? "Bezig..." : "Opslaan"}
            </Button>
          </div>
        </form>
      </CardContent>
    </Card>
  );
}