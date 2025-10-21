import React, { useState, useEffect } from "react";
import { base44 } from "@/api/base44Client";
import { useMutation, useQueryClient } from "@tanstack/react-query";
import { useNavigate } from "react-router-dom";
import { createPageUrl } from "@/utils";
import { ArrowLeft } from "lucide-react";
import { Button } from "@/components/ui/button";
import EventForm from "../components/events/EventForm";

export default function NieuwOptreden() {
  const navigate = useNavigate();
  const queryClient = useQueryClient();

  useEffect(() => {
    base44.auth.me().catch(() => {
      base44.auth.redirectToLogin();
    });
  }, []);

  const createEventMutation = useMutation({
    mutationFn: (data) => base44.entities.Event.create(data),
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['events'] });
      navigate(createPageUrl("Dashboard"));
    },
  });

  const handleSubmit = (data) => {
    createEventMutation.mutate(data);
  };

  return (
    <div className="max-w-3xl mx-auto space-y-6">
      <div className="flex items-center gap-4">
        <Button
          variant="outline"
          size="icon"
          onClick={() => navigate(createPageUrl("Dashboard"))}
          className="bg-white/95 border-purple-200 hover:bg-purple-50"
        >
          <ArrowLeft className="w-4 h-4" />
        </Button>
        <div>
          <h1 className="text-3xl font-bold text-white">Nieuw Optreden</h1>
          <p className="text-purple-100">Voeg een nieuw optreden toe aan je agenda</p>
        </div>
      </div>

      <EventForm
        onSubmit={handleSubmit}
        onCancel={() => navigate(createPageUrl("Dashboard"))}
        isProcessing={createEventMutation.isPending}
      />
    </div>
  );
}